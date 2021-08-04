<?php

namespace Modules\Users\Http\Controllers;

use App\Reference;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Dingo\Api\Auth\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Point;
use Modules\Dealers\Entities\Dealer;
use Modules\Balances\Entities\BalanceHistories;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (\Sentinel::getUser()->hasAccess('leave.approve')) {
            $_SESSION['menu'] = 'approval';
            $dealers = Dealer::all();
            //dd($types);
            $array_dealers = array();
            foreach ($dealers as $dealer) {
               $array_dealers += [
                 $dealer->id  => strtoupper($dealer->name),
               ];
            }

            return view('users::approval.index',['array_dealers' => $array_dealers]);
        } else {
            return redirect()->route('dashboard')->with('error', 'Access denied!');
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        if (\Sentinel::getUser()->hasAccess('technician.show')) {
            $_SESSION['menu'] = 'approval';
            $user = User::find($id);
            return view('users::approval.show', [
                'user' => $user
            ]);
        } else {
            return redirect()->route('dashboard')->with('error', 'Access denied!');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function approve($id,Request $request)
    {  
        $data = $request->all();
//        $id = $data['technician_id'];
        if (\Sentinel::getUser()->hasAccess('technician.approve')) {
            $user = \Sentinel::findUserById($id);

            // Check if user is a technician
            if(!$user->inRole('technician'))
                return redirect()->route('technician.show', $id)->with('success', 'User yang akan disetujui bukan teknisi');

            // Check if user status is not approved
            if($user->status <> User::NOTAPPROVED)
                return redirect()->route('technician.show', $id)->with('success', 'Teknisi telah disetujui');

            // Set Technician status to active
//            $user->dealer_id = $data['dealer_id'];
            $user->status = User::ACTIVE;

            $cashback_percent_setting = getSetting('starting_balance');
            if($cashback_percent_setting && $cashback_percent_setting > 0){
                BalanceHistories::createBalanceHistories($user, null, BalanceHistories::STARTINGBALANCE, "Bonus awal balance sebesar Rp ".number_format($cashback_percent_setting,0), $cashback_percent_setting);

            }

            // Get approver data
            $user->approved_by = \Sentinel::getUser()->id;
            $user->approved_at = date('Y-m-d H:i:s', strtotime('now'));

            $user->save();


            if (\Sentinel::getUser()->hasAccess('technician.show'))
                return redirect()->route('technician.show', $id)->with('success', 'Teknisi telah disetujui');
            else
                return redirect()->route('technician.approval.index')->with('success', 'Teknisi telah disetujui');
        } else {
            return redirect()->route('dashboard')->with('error', 'Access denied!');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        if (\Sentinel::getUser()->hasAccess('technician.delete')) {
            $_SESSION['menu'] = 'approval';
            $user = User::find($id);
            $user->status = User::DELETED;
            $user->save();
            return redirect()->route('technician.index')->with('success', 'Technician deleted');
        } else {
            return redirect()->route('dashboard')->with('error', 'Access denied!');
        }
    }

    public function ajaxListApprovalTechnician(Request $request)
    {
        if (\Sentinel::getUser()->hasAccess('technician.list') || \Sentinel::getUser()->hasAccess('technician.approve')) {
            $columns = array(
                0 => 'username',
                1 => 'email',
                2 => 'fullname',
                3 => 'status',
                4 => 'created_at',
//            5 => 'updated_at',
                5 => 'actions',
            );

            $role = \Sentinel::findRoleById(4); // technician role ID

            $totalData = $role->users()->where('status', '=', User::NOTAPPROVED)->count();
            $totalFiltered = $totalData;
//        dd($request->input('order.0.column'));
            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $role = \Sentinel::findRoleById(4);
            $users = $role->users();


            if (empty($request->input('search.value'))) {
                $users = $users->where('status', '=', User::NOTAPPROVED)->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $users = $users->where('status', '=', User::NOTAPPROVED)->where(function ($query) use ($search) {
                    $query->where('username', 'LIKE', "%{$search}%")
                        ->orWhere('fullname', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $role = \Sentinel::findRoleById(4); // Customer role ID
                $totalFiltered = $role->users()->where('status', '=', User::NOTAPPROVED)->where(function ($query) use ($search) {
                    $query->where('username', 'LIKE', "%{$search}%")
                        ->orWhere('fullname', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })
                    ->count();
            }

            $data = array();
            if (!empty($users)) {
                foreach ($users as $user) {
                    $show = $edit = $delete = '';

                    if (\Sentinel::getUser()->hasAccess('technician.show'))
                        $show = "<a href='" . route('technician.show', $user->id) . "' title='Show' ><span class='icon-file-text'></span></a>";

                        if (\Sentinel::getUser()->hasAccess('technician.approve')){
//                            $edit = '<a id="modal_remove_button" href="#modal_saldo" data-toggle="modal"
//                                               data-target="#modal_saldo" data-id="'.$user->id.'" data-dealer="'.$user->dealer_inputed.'"
//                                               onclick="setDealer(this)" title="Set dealer & Approve"><span class="icon-checkmark"></a>';
                             $edit = "<a href='" . route('technician.approval', $user->id) . "' title='Approve' ><span class='icon-checkmark'></span></a>";
                        }

                    if (\Sentinel::getUser()->hasAccess('technician.delete'))
                        $delete = "<a href='" . route('technician.deleteTechnician', $user->id) . "' title='Delete' class='confirmAction'><span class='icon-trash'></span></a>";

                    $nestedData['username'] = $user->username;
                    $nestedData['email'] = $user->email;
                    $nestedData['fullname'] = $user->fullname;
                    $nestedData['status'] = $user->status;
                    $nestedData['created_at'] = date('j M Y h:i a', strtotime($user->created_at));
//                $nestedData['updated_at'] = date('j M Y h:i a', strtotime($user->updated_at));
                    $nestedData['actions'] = "&emsp;$show
                                          &emsp;$edit
                                          &emsp;$delete";
                    $data[] = $nestedData;

                }
            }
            $json_data = array(
                "draw" => intval($request->input('draw')),
                "recordsTotal" => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data" => $data
            );

            return json_encode($json_data);
        }else{
            return false;
        }
    }
}
