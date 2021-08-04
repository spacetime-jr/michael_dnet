<?php

namespace Modules\Users\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Point;
use Modules\Users\Entities\Ijin;

class IjinController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (\Sentinel::getUser()->hasAccess('ijin.approval')) {
            $_SESSION['menu'] = 'ijin';
            return view('users::ijin.index');
        } else {
            return redirect()->route('dashboard')->with('error', 'Access dennied!');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        if (\Sentinel::getUser()->hasAccess('ijin.approval')) {
            $_SESSION['menu'] = 'ijin';
            return view('users::ijin.create', [
                'start_date' => Carbon::now()->setTimezone('Asia/Jakarta')->format('m/d/Y'),
                'end_date' => Carbon::now()->setTimezone('Asia/Jakarta')->format('m/d/Y'),
            ]);
        } else {
            return redirect()->route('dashboard')->with('error', 'Access dennied!');
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (\Sentinel::getUser()->hasAccess('ijin.approval')) {
            $rules = [
                'user_id' => 'required|exists:users,id',
                'tanggal_cuti' => 'required',
                'type' => 'required',
            ];
            $data = $request->all();

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()
                    ->route('ijin.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            try{
                // get the user
                $user = User::find($data['user_id']);
                if(empty($user))
                    throw new \Exception('Pegawai tidak ditemukan');

                // Process the date
                $ijinDate = explode(' - ',$data['tanggal_cuti']);

                $ijinStartDate = $ijinDate[0];
                $ijinEndDate = $ijinDate[1];
                
                // get working days
                $workingDays = getWorkingDays($ijinStartDate, $ijinEndDate);

                \DB::beginTransaction();

                // Check if its cuti or ijin
                $cutiGaji = 0;
                $cuti = 0;
                switch($data['type']) {
                    case \Modules\Users\Entities\Ijin::CUTI :
                    case \Modules\Users\Entities\Ijin::SAKIT :
                        if($workingDays > $user->cuti_sisa){
                            $cuti = $user->cuti_sisa;
                            $cutiGaji =  $workingDays - $user->cuti_sisa;
                            $user->cuti_sisa = 0;
                        }else{
                            $cuti = $workingDays;
                            $user->cuti_sisa = $user->cuti_sisa - $workingDays;
                        }
                        // Save sisa cuti user
                        $user->save();
                        break;
                    case \Modules\Users\Entities\Ijin::CUTIGAJI :
                        $cutiGaji = $workingDays;
                        break;
                }

                
                $ijin = new Ijin();
                $ijin->start_date = Carbon::createFromFormat('m/d/Y', $ijinStartDate)->format('Y-m-d');
                $ijin->end_date = Carbon::createFromFormat('m/d/Y', $ijinEndDate)->format('Y-m-d');
                $ijin->user_id = $data['user_id'];
                $ijin->type = $data['type'];
                $ijin->cuti_terpakai = $cuti;
                $ijin->status = Ijin::APPROVED;
                $ijin->jumlah_hari_potong_gaji = $cutiGaji;
                $ijin->jumlah_hari_kerja = $workingDays;
                $ijin->approved_by = \Sentinel::getUser()->id;
                $ijin->approved_at = Carbon::now()->format('Y-m-d H:i:s');
                $ijin->save();    
    
                \DB::commit();
    
                return redirect()->route('ijin.index')->with('success', 'Ijin telah dibuat');
            }catch(\Exception $e){
                \DB::rollBack();
                return redirect()->route('ijin.index')->with('error', $e->getMessage());
            }
            // Process the date
            
        } else {
            return redirect()->route('dashboard')->with('error', 'Access dennied!');
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('users::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function ajaxListIjin(Request $request)
    {
        if (\Sentinel::getUser()->hasAccess('ijin.approval')) {
            $columns = array(
                0 => 'users.fullname',
                1 => 'start_date',
                2 => 'end_date',
                3 => 'type',
                4 => 'cuti_terpakai',
                5 => 'jumlah_hari_potong_gaji',
                6 => 'jumlah_hari_kerja',
                7 => 'ijin.status',
                8 => 'approver.fullname',
                9 => 'created_at',
            );

            $totalData = \DB::table('ijin');
                // ->join('users', 'users.id', '=', 'ijin.user_id')
                // ->join('users as approver', 'approver.id', '=', 'ijin.approved_by')

            $totalData = $totalData->count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            
            $ijins = \DB::table('ijin')
                ->join('users', 'users.id', '=', 'ijin.user_id')
                ->join('users as approver', 'approver.id', '=', 'ijin.approved_by')
                ->select('ijin.*');


            if (empty($request->input('search.value'))) {
                $ijins = $ijins
                    ->addSelect('users.fullname AS users_fullname')
                    ->addSelect('approver.fullname AS approver_fullname')->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $totalFiltered = $ijins;
                $ijins = $ijins->where(function ($query) use ($search) {
                    $query->where('users.fullname', 'LIKE', "%{$search}%")
                        ->orWhere('approver.fullname', 'LIKE', "%{$search}%")
                        ->orWhere('start_date', 'LIKE', "%{$search}%")
                        ->orWhere('jumlah_hari_kerja', 'LIKE', "%{$search}%")
                        ->orWhere('type', 'LIKE', "%{$search}%")
                        ->orWhere('ijin.created_at', 'LIKE', "%{$search}%")
                        ->orWhere('end_date', 'LIKE', "%{$search}%");
                })
                ->addSelect('users.fullname AS users_fullname')
                ->addSelect('approver.fullname AS approver_fullname')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

                $totalFiltered = $totalFiltered->where(function ($query) use ($search) {
                    $query->where('users.fullname', 'LIKE', "%{$search}%")
                        ->orWhere('approver.fullname', 'LIKE', "%{$search}%")
                        ->orWhere('start_date', 'LIKE', "%{$search}%")
                        ->orWhere('jumlah_hari_kerja', 'LIKE', "%{$search}%")
                        ->orWhere('type', 'LIKE', "%{$search}%")
                        ->orWhere('ijin.created_at', 'LIKE', "%{$search}%")
                        ->orWhere('end_date', 'LIKE', "%{$search}%");
                })->count();
            }
            $data = array();
            if (!empty($ijins)) {
                foreach ($ijins as $ijin) {
                    $show = $edit = $delete = '';

                    // if (\Sentinel::getUser()->hasAccess('ijin.approval'))
                    //     $edit = "<a href='" . route('ijin.edit', $ijin->id) . "' title='Edit' ><span class='icon-pencil'></span></a>";

                    // if (\Sentinel::getUser()->hasAccess('user.delete'))
                    //     $delete = "<a href='" . route('users.deleteUser', $user->id) . "' title='Delete' class='confirmAction'><span class='icon-trash'></span></a>";

                    $nestedData['ufullname'] = $ijin->users_fullname;
                    $nestedData['start_date'] = $ijin->start_date;
                    $nestedData['end_date'] = $ijin->end_date;
                    $nestedData['type'] = $ijin->status;
                    $nestedData['cuti_terpakai'] = $ijin->cuti_terpakai . ' Hari';
                    $nestedData['jumlah_hari_potong_gaji'] = $ijin->jumlah_hari_potong_gaji . ' Hari';
                    $nestedData['jumlah_hari_kerja'] = $ijin->jumlah_hari_kerja . ' Hari';
                    $nestedData['status'] = $ijin->status;
                    $nestedData['afullname'] = $ijin->approver_fullname;
                    $nestedData['created_at'] = date('j M Y h:i a', strtotime($ijin->created_at));
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
        } else {
            return false;
        }
    }
}
