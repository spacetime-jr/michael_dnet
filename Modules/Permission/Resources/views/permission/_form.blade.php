<?php
if (!isset($method)) {
    $method = 'post';
}
?>

{{ Form::open(array('action' => $action, 'method' => $method, 'class' => 'form-horizontal')) }}
<fieldset class="content-group">
    <!-- ========================================================================================== -->
    <div class="form-group">
        <div class="col-lg-12">
            <table style="width: 100%">
                <tr>
                    <td><b> Nama </b></td>
                    <td>:</td>
                    <td><div class="col-lg-10"> <b>{{isset($role->name) ? $role->name : ''}} </b></div></td>
                </tr>
                <tr>
                    <td>  Login </td>
                    <td>:</td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="adminlogin" value="true" <?php if($role->hasAccess("admin.login")) { ?> checked <?php } ?>>
                                Admin Login
                            </label>
                        </div>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @php
                /*
                <tr>
                    <td>  Acitivty Log </td>
                    <td>:</td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="activitylog" value="true" <?php if($role->hasAccess("activity.log")) { ?> checked <?php } ?>>
                                Show
                            </label>
                        </div>
                    </td>
                </tr>
                */
                @endphp
                <tr>
                    <td>User</td>
                    <td>:</td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="userlist" value="true" <?php if($role->hasAccess("user.list")) { ?> checked <?php } ?>>
                                User List
                            </label>
                        </div>
                    </td>
                    @php
                    /*
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="usershow" value="true" <?php if($role->hasAccess("user.show")) { ?> checked <?php } ?>>
                                User Show
                            </label>
                        </div>
                    </td>
                    */
                    @endphp
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="usercreate" value="true" <?php if($role->hasAccess("user.create")) { ?> checked <?php } ?>>
                                User Create
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="useredit" value="true" <?php if($role->hasAccess("user.edit")) { ?> checked <?php } ?>>
                                User Edit
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="userdelete" value="true" <?php if($role->hasAccess("user.delete")) { ?> checked <?php } ?>>
                                User Delete
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Employee</td>
                    <td>:</td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="employeelist" value="true" <?php if($role->hasAccess("employee.list")) { ?> checked <?php } ?>>
                                Employee List
                            </label>
                        </div>
                    </td>
                    @php
                    /*
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="employeeshow" value="true" <?php if($role->hasAccess("employee.show")) { ?> checked <?php } ?>>
                                Employee Show
                            </label>
                        </div>
                    </td>
                    */
                    @endphp
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="employeecreate" value="true" <?php if($role->hasAccess("employee.create")) { ?> checked <?php } ?>>
                                Employee Create
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="employeeedit" value="true" <?php if($role->hasAccess("employee.edit")) { ?> checked <?php } ?>>
                                Employee Edit
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="employeedelete" value="true" <?php if($role->hasAccess("employee.delete")) { ?> checked <?php } ?>>
                                Employee Delete
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Human Resource</td>
                    <td>:</td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="hruserlist" value="true" <?php if($role->hasAccess("hr.user.list")) { ?> checked <?php } ?>>
                                HR List
                            </label>
                        </div>
                    </td>
                    @php
                    /*
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="hrusershow" value="true" <?php if($role->hasAccess("hr.user.show")) { ?> checked <?php } ?>>
                                HR Show
                            </label>
                        </div>
                    </td>
                    */
                    @endphp
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="hrusercreate" value="true" <?php if($role->hasAccess("hr.user.create")) { ?> checked <?php } ?>>
                                HR Create
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="hruseredit" value="true" <?php if($role->hasAccess("hr.user.edit")) { ?> checked <?php } ?>>
                                HR Edit
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="hruserdelete" value="true" <?php if($role->hasAccess("hr.user.delete")) { ?> checked <?php } ?>>
                                HR Delete
                            </label>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>Permission</td>
                    <td>:</td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="permissionlist" value="true" <?php if($role->hasAccess("permission.list")) { ?> checked <?php } ?>>
                                Permission List
                            </label>
                        </div>
                    </td>
                    
                    @php
                    /*
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="permissionshow" value="true" <?php if($role->hasAccess("permission.show")) { ?> checked <?php } ?>>
                                Permission Show
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="permissioncreate" value="true" <?php if($role->hasAccess("permission.create")) { ?> checked <?php } ?>>
                                Permission Create
                            </label>
                        </div>
                    </td>
                    */
                    @endphp
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="permissionedit" value="true" <?php if($role->hasAccess("permission.edit")) { ?> checked <?php } ?>>
                                Permission Edit
                            </label>
                        </div>
                    </td>
                    
                    @php
                    /*
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="permissiondelete" value="true" <?php if($role->hasAccess("permission.delete")) { ?> checked <?php } ?>>
                                Permission Delete
                            </label>
                        </div>
                    </td>
                    */
                    @endphp
                </tr>

                <tr>
                    <td>Laporan</td>
                    <td>:</td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="reportabsensi" value="true" <?php if($role->hasAccess("report.absensi")) { ?> checked <?php } ?>>
                                Laporan Absensi
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="reportijin" value="true" <?php if($role->hasAccess("report.ijin")) { ?> checked <?php } ?>>
                                Laporan Ijin/Cuti
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="reportgaji" value="true" <?php if($role->hasAccess("report.gaji")) { ?> checked <?php } ?>>
                                Laporan Gaji
                            </label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Ijin/Cuti</td>
                    <td>:</td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="pengajuanijin" value="true" <?php if($role->hasAccess("ijin.pengajuan")) { ?> checked <?php } ?>>
                                Pengajuan Ijin (To-be Implemented)
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="approvalijin" value="true" <?php if($role->hasAccess("ijin.approval")) { ?> checked <?php } ?>>
                                Approval Ijin
                            </label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Setting</td>
                    <td>:</td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="settinglist" value="true" <?php if($role->hasAccess("setting.list")) { ?> checked <?php } ?>>
                                Setting List
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="settingshow" value="true" <?php if($role->hasAccess("setting.show")) { ?> checked <?php } ?>>
                                Setting Show
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="col-lg-10">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="settingedit" value="true" <?php if($role->hasAccess("setting.edit")) { ?> checked <?php } ?>>
                                Setting Edit
                            </label>
                        </div>
                    </td>
                </tr>

            </table>
        </div>
    </div>
   
</fieldset>
<?php if(isset($currentRole)){?>
<input type="hidden" name="old_role" value="<?php echo $currentRole?>">
<?php } ?>
<div class="text-right">
    <button type="submit" class="btn btn-primary">Submit <i class="icon-arrow-right14 position-right"></i></button>
</div>
{{ Form::close() }}