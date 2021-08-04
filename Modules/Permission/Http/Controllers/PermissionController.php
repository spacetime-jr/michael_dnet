<?php

namespace Modules\Permission\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


use App\Reference;
use Carbon\Carbon;
use Sentinel;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if (\Sentinel::getUser()->hasAccess('permission.list')) {
            $_SESSION['menu'] = 'permission';

            $roles = \Sentinel::getRoleRepository();
            $roles = $roles->all();
            return view('permission::permission.index',
                [
                    'roles' => $roles
                ]);
        } else {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        if (\Sentinel::getUser()->hasAccess('permission.create')) {
            $_SESSION['menu'] = 'permission';
            return view('permission::permission.create');
        } else {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if (\Sentinel::getUser()->hasAccess('permission.create')) {
            $_SESSION['menu'] = 'permission';
            return view('permission::permission.create');
        } else {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {   
        return redirect()->route('dashboard')->with('error', 'Fitur Sedang Dalam Pengerjaan');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        if (\Sentinel::getUser()->hasAccess('permission.edit')) {
            $_SESSION['menu'] = 'permission';
            $role = \Sentinel::getRoleRepository()->find($id);
            //dd($role);
            // if($role->hasAccess('permission.edit')){
            //     dd("bisa permission edit");
            // }
            return view('permission::permission.edit', [
                'role' => $role
            ]);
        } else {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update($id, Request $request)
    {
        //dd($request);
        if (\Sentinel::getUser()->hasAccess('permission.edit')) {
            ($request["adminlogin"] == "true")?$adminlogin=true:$adminlogin=false;
            ($request["modulechange"] == "true")?$modulechange=true:$modulechange=false;

            ($request["activitylog"] == "true")?$activitylog=true:$activitylog=false;

            ($request["userlist"] == "true")?$userlist=true:$userlist=false;
            ($request["usershow"] == "true")?$usershow=true:$usershow=false;
            ($request["usercreate"] == "true")?$usercreate=true:$usercreate=false;
            ($request["useredit"] == "true")?$useredit=true:$useredit=false;
            ($request["userdelete"] == "true")?$userdelete=true:$userdelete=false;

            ($request["employeelist"] == "true")?$employeelist=true:$employeelist=false;
            ($request["employeeshow"] == "true")?$employeeshow=true:$employeeshow=false;
            ($request["employeecreate"] == "true")?$employeecreate=true:$employeecreate=false;
            ($request["employeeedit"] == "true")?$employeeedit=true:$employeeedit=false;
            ($request["employeedelete"] == "true")?$employeedelete=true:$employeedelete=false;

            ($request["hruserlist"] == "true")?$hruserlist=true:$hruserlist=false;
            ($request["hrusershow"] == "true")?$hrusershow=true:$hrusershow=false;
            ($request["hrusercreate"] == "true")?$hrusercreate=true:$hrusercreate=false;
            ($request["hruseredit"] == "true")?$hruseredit=true:$hruseredit=false;
            ($request["hruserdelete"] == "true")?$hruserdelete=true:$hruserdelete=false;

            ($request["permissionlist"] == "true")?$permissionlist=true:$permissionlist=false;
            ($request["permissionshow"] == "true")?$permissionshow=true:$permissionshow=false;
            ($request["permissioncreate"] == "true")?$permissioncreate=true:$permissioncreate=false;
            ($request["permissionedit"] == "true")?$permissionedit=true:$permissionedit=false;
            ($request["permissiondelete"] == "true")?$permissiondelete=true:$permissiondelete=false;

            ($request["reportabsensi"] == "true")?$reportabsensi=true:$reportabsensi=false;
            ($request["reportijin"] == "true")?$reportijin=true:$reportijin=false;
            ($request["reportgaji"] == "true")?$reportgaji=true:$reportgaji=false;

            ($request["pengajuanijin"] == "true")?$pengajuanijin=true:$pengajuanijin=false;
            ($request["approvalijin"] == "true")?$approvalijin=true:$approvalijin=false;

            ($request["settinglist"] == "true")?$settinglist=true:$settinglist=false;
            ($request["settingshow"] == "true")?$settingshow=true:$settingshow=false;
            ($request["settingcreate"] == "true")?$settingcreate=true:$settingcreate=false;
            ($request["settingedit"] == "true")?$settingedit=true:$settingedit=false;
            ($request["settingdelete"] == "true")?$settingdelete=true:$settingdelete=false;

            ($request["slideshowlist"] == "true")?$slideshowlist=true:$slideshowlist=false;
            ($request["slideshowshow"] == "true")?$slideshowshow=true:$slideshowshow=false;
            ($request["slideshowcreate"] == "true")?$slideshowcreate=true:$slideshowcreate=false;
            ($request["slideshowedit"] == "true")?$slideshowedit=true:$slideshowedit=false;
            ($request["slideshowdelete"] == "true")?$slideshowdelete=true:$slideshowdelete=false;


            $role = \Sentinel::getRoleRepository()->find($id);
            $role->permissions = [
                'admin.login' => $adminlogin,
                'module.change' => $modulechange,

                'activity.log' => $activitylog,

                'user.list' => $userlist,
                'user.show' => $usershow,
                'user.edit' => $useredit,
                'user.delete' => $userdelete,
                'user.create' => $usercreate,

                'employee.list' => $employeelist,
                'employee.show' => $employeeshow,
                'employee.edit' => $employeeedit,
                'employee.delete' => $employeedelete,
                'employee.create' => $employeecreate,

                'hr.user.list' => $hruserlist,
                'hr.user.show' => $hrusershow,
                'hr.user.edit' => $hruseredit,
                'hr.user.delete' => $hruserdelete,
                'hr.user.create' => $hrusercreate,

                'permission.list' => $permissionlist,
                'permission.show' => $permissionshow,
                'permission.edit' => $permissionedit,
                'permission.delete' => $permissiondelete,
                'permission.create' => $permissioncreate,

                'report.absensi' => $reportabsensi,
                'report.ijin' => $reportijin,
                'report.gaji' => $reportgaji,

                'setting.list' => $settinglist,
                'setting.show' => $settingshow,
                'setting.edit' => $settingedit,
                'setting.delete' => $settingdelete,
                'setting.create' => $settingcreate,


                'slideshow.list' => $slideshowlist,
                'slideshow.show' => $slideshowshow,
                'slideshow.edit' => $slideshowedit,
                'slideshow.delete' => $slideshowdelete,
                'slideshow.create' => $slideshowcreate,

                'ijin.approval' => $approvalijin,
                'ijin.pengajuan' => $pengajuanijin,

                'report.ijin' => $reportijin,
                'report.absensi' => $reportabsensi,
                'report.gaji' => $reportgaji

            ];

            //dd($role);
            $role->save();

            return redirect()->route('permission.index')->with('success', 'Role Permission berhasil di ubah');
        } else {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        if (\Sentinel::getUser()->hasAccess('reference.delete')) {
            $_SESSION['menu'] = 'references';
            $references = Reference::find($id);
            $references['status'] = Reference::DELETED;
            $references->save();
            
            
            return redirect()->route('reference.index')->with('success', 'Reference berhasil di hapus');
        } else {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }
    }
}
