<?php

namespace Modules\Users\Http\Controllers;

use App\Device;
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

class HrController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (\Sentinel::getUser()->hasAccess('hr.user.list')) {
            $_SESSION['menu'] = 'hr';
            return view('users::hr.index');
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
        $user = \Sentinel::getUser();
        if (\Sentinel::getUser()->hasAccess('hr.user.create')) {
            $_SESSION['menu'] = 'hr';

            $roles = \Sentinel::getRoleRepository();

            // Gett all available roles except super admin
            $roles = $roles->where('id', '<>', env('SUPERADMIN_ROLE_ID','1'));

            $roles = $roles->get();

            return view('users::hr.create', [
                'roles' => $roles,
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
        if (\Sentinel::getUser()->hasAccess('hr.user.create')) {
            $rules = [
                'fullname' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'username' => 'required|unique:users|min:3',
                'phone_number' => 'required|unique:users',
                'address' => 'required|string',
                'role' => 'required',
                'password' => 'required|min:6',
                'birthday' => 'date_format:d-m-Y|before:today',
                'birthplace' => 'required|string',
                'gaji' => 'required|numeric|gte:0',
            ];
            $data = $request->all();


            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()
                    ->route('hr.create')
                    ->withErrors($validator)
                    ->withInput();
            }

            $userData = [];
            $userData['fullname'] = $request['fullname'];
            $userData['email'] = $request['email'];
            $userData['username'] = $request['username'];
            $userData['password'] = $request['password'];
            $userData['phone_number'] = $request['phone_number'];
            $userData['address'] = $request['address'];
            $userData['birthplace'] = $request['birthplace'];
            $date = new \DateTime($request['birthday']);
            $userData['birthday'] = $date->format('Y-m-d');
            $userData['gaji'] = $request['gaji'];

            

            $user = \Sentinel::registerAndActivate($userData);

            $role = \Sentinel::findRoleBySlug($data['role']);
            $role->users()->attach($user);

            $user->status = $request['status'];
            $user->save();

            return redirect()->route('hr.edit', $user->id)->with('success', 'User saved');
        } else {
            return redirect()->route('dashboard')->with('error', 'Access dennied!');
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        if (\Sentinel::getUser()->hasAccess('hr.user.show')) {
            $_SESSION['menu'] = 'hr';
            $user = User::find($id);



            return view('users::user.show', [
                'user' => $user,
            ]);
        } else {
            return redirect()->route('dashboard')->with('error', 'Access dennied!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $currentUser = \Sentinel::getUser();
        if (\Sentinel::getUser()->hasAccess('hr.user.edit')   || \Auth::user()->id == $id) {
            try{
                $_SESSION['menu'] = 'hr';
                $user = \Sentinel::findById($id);

                $roles = \Sentinel::getRoleRepository();
                // Exclude super admin role id
                $roles = $roles->where('id', '<>', env('SUPERADMIN_ROLE_ID','1'));
                $roles = $roles->get();

                $currentRole = \Sentinel::findById($user->id)->roles[0]->slug;
                return view('users::hr.edit', [
                    'user' => $user,
                    'roles' => $roles,
                    'currentRole' => $currentRole,
                ]);
            }catch(\Exception $e){
                return redirect()->route('hr.index')->with('error', $e->getMessage());
            }

        } else {
            return redirect()->route('dashboard')->with('error', 'Access dennied!');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        if (\Sentinel::getUser()->hasAccess('hr.user.edit')  || \Auth::user()->id == $id) {
            $user = \Sentinel::findUserById($id);
            $rules = [
                'fullname' => 'required|min:3',
                'email' => ['required', 'email', Rule::unique('users')->where(function ($query) use ($user) {
                    return $query->where('id', '<>', $user->id);
                })],
                'username' => ['required', 'min:3', Rule::unique('users')->where(function ($query) use ($user) {
                    return $query->where('id', '<>', $user->id);
                })],
                'phone_number' => ['required', Rule::unique('users')->where(function ($query) use ($user) {
                    return $query->where('id', '<>', $user->id);
                })],
                'address' => 'required|string',
                'password' => 'nullable|min:6',
                
                'birthday' => 'date_format:d-m-Y|before:today',
                'birthplace' => 'required|string',
                'gaji' => 'required|numeric|gte:0',
                'gender' => [
                    'required',
                    Rule::in(['male', 'female']),
                ],
            ];
            $data = $request->all();


            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()
                    ->route('hr..edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }

            $userData = [];
            $userData['fullname'] = $request['fullname'];
            $userData['email'] = $request['email'];
            $userData['username'] = $request['username'];
            if ($request['password'])
                $userData['password'] = $request['password'];
            $userData['phone_number'] = $request['phone_number'];
            $userData['address'] = $request['address'];
            $userData['birthplace'] = $request['birthplace'];
            $date = new \DateTime($request['birthday']);
            $userData['birthday'] = $date->format('Y-m-d');
            $userData['gaji'] = $request['gaji'];
            $userData['gender'] = $request['gender'];

            \Sentinel::update($user, $userData);

            $role = \Sentinel::findRoleBySlug($data['role']);
            $old_role = \Sentinel::findRoleBySlug($data['old_role']);
            $old_role->users()->detach($user);
            $role->users()->attach($user);

            $user->status = $request['status'];
            $user->save();


            return redirect()->route('hr.edit', $id)->with('success', 'User updated');
        } else {
            return redirect()->route('dashboard')->with('error', 'Access dennied!');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        if (\Sentinel::getUser()->hasAccess('hr.user.delete')) {
            $_SESSION['menu'] = 'hr';
            $user = User::find($id);
//            $user->delete();
            $user->email = null;
            $user->phone_number = null;
            $user->status = User::DELETED;
            $user->save();
            return redirect()->route('hr.index')->with('success', 'User deleted');
        } else {
            return redirect()->route('dashboard')->with('error', 'Access dennied!');
        }
    }

    /**
     * Get View Layout for ofrgot pass
     * @param $id
     * @param $code
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getForgot($id, $code)
    {
        $user = Sentinel::findUserById($id);

        if (Reminder::exists($user, $code)) {
            return view('users::user.forgotPass', ['id' => $id, 'code' => $code]);
        } else {
            //incorrect info was passed
            return view('users::user.errorForgotPass');
        }

    }


    public function ajaxListHr(Request $request)
    {
        if (\Sentinel::getUser()->hasAccess('hr.user.list')) {
            $hr_id = env('HR_ROLE_ID',2);
            $columns = array(
                0 => 'username',
                1 => 'email',
                2 => 'fullname',
                3 => 'status',
                4 => 'users.created_at',
//            5 => 'updated_at',
                5 => 'actions',
            );

            // COunt total HR user
            $role = \Sentinel::findRoleById($hr_id); // HR role ID

            $totalData = $role->users()
                ->where('users.status', '<>', User::DELETED);

            $totalData = $totalData->count();

            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $users = \Sentinel::findRoleById($hr_id)->users();


            if (empty($request->input('search.value'))) {
                $users = $users->where('status', '<>', User::DELETED)->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $totalFiltered = $users;
                $users = $users->where('status', '<>', User::DELETED)->where(function ($query) use ($search) {
                    $query->where('username', 'LIKE', "%{$search}%")
                        ->orWhere('fullname', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = $totalFiltered->where('status', '<>', User::DELETED)->where(function ($query) use ($search) {
                    $query->where('username', 'LIKE', "%{$search}%")
                        ->orWhere('fullname', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->count();
            }

            $data = array();
            if (!empty($users)) {
                foreach ($users as $user) {
                    $show = $edit = $delete = '';

                    //if (\Sentinel::getUser()->hasAccess('hr.user.show'))
                        //$show = "<a href='" . route('hr.user.show', $user->id) . "' title='Show' ><span class='icon-file-text'></span></a>";

                    if (\Sentinel::getUser()->hasAccess('hr.user.edit'))
                        $edit = "<a href='" . route('hr.edit', $user->id) . "' title='Edit' ><span class='icon-pencil'></span></a>";

                    if (\Sentinel::getUser()->hasAccess('hr.user.delete'))
                        $delete = "<a href='" . route('hr.deleteUser', $user->id) . "' title='Delete' class='confirmAction'><span class='icon-trash'></span></a>";

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
        } else {
            return false;
        }
    }
}
