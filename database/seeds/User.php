<?php

use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            \DB::beginTransaction();
/*
		*  Adding Roles
		*/
		$role = Sentinel::getRoleRepository()->createModel()->create([
            'id' => 1,
			'name' => 'Super Admin',
			'slug' => 'superadmin',
		]);
		$role->permissions =[
            "admin.login"=> true,
            "module.change"=> false,
            "activity.log"=> false,
            "user.list"=> true,
            "user.show"=> false,
            "user.edit"=> true,
            "user.delete"=> true,
            "user.create"=> true,
            "employee.list"=> true,
            "employee.show"=> false,
            "employee.edit"=> true,
            "employee.delete"=> true,
            "employee.create"=> true,
            "hr.user.list"=> true,
            "hr.user.show"=> false,
            "hr.user.edit"=> true,
            "hr.user.delete"=> true,
            "hr.user.create"=> true,
            "permission.list"=> true,
            "permission.show"=> false,
            "permission.edit"=> true,
            "permission.delete"=> false,
            "permission.create"=> false,
            "report.absensi"=> true,
            "report.ijin"=> true,
            "report.gaji"=> true,
            "setting.list"=> true,
            "setting.show"=> true,
            "setting.edit"=> true,
            "setting.delete"=> false,
            "setting.create"=> false,
            "slideshow.list"=> false,
            "slideshow.show"=> false,
            "slideshow.edit"=> false,
            "slideshow.delete"=> false,
            "slideshow.create"=> false,
            "ijin.approval"=> true,
            "ijin.pengajuan"=> true
		];
		$role->save();
		
		$role = Sentinel::getRoleRepository()->createModel()->create([
            'id' => 2,
			'name' => 'HR',
			'slug' => 'hr',
		]);
		$role->permissions =[
            "admin.login"=> true,
            "module.change"=> false,
            "activity.log"=> false,
            "user.list"=> false,
            "user.show"=> false,
            "user.edit"=> false,
            "user.delete"=> false,
            "user.create"=> false,
            "employee.list"=> true,
            "employee.show"=> false,
            "employee.edit"=> true,
            "employee.delete"=> true,
            "employee.create"=> true,
            "hr.user.list"=> true,
            "hr.user.show"=> false,
            "hr.user.edit"=> true,
            "hr.user.delete"=> true,
            "hr.user.create"=> true,
            "permission.list"=> false,
            "permission.show"=> false,
            "permission.edit"=> false,
            "permission.delete"=> false,
            "permission.create"=> false,
            "report.absensi"=> true,
            "report.ijin"=> true,
            "report.gaji"=> true,
            "setting.list"=> false,
            "setting.show"=> false,
            "setting.edit"=> false,
            "setting.delete"=> false,
            "setting.create"=> false,
            "slideshow.list"=> false,
            "slideshow.show"=> false,
            "slideshow.edit"=> false,
            "slideshow.delete"=> false,
            "slideshow.create"=> false,
            "ijin.approval"=> true,
            "ijin.pengajuan"=> false
		];
		$role->save();

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'id' => 3,
            'name' => 'Employee',
            'slug' => 'employee',
        ]);
        $role->permissions =[
            "admin.login"=> true,
            "module.change"=> false,
            "activity.log"=> false,
            "user.list"=> false,
            "user.show"=> false,
            "user.edit"=> false,
            "user.delete"=> false,
            "user.create"=> false,
            "employee.list"=> false,
            "employee.show"=> false,
            "employee.edit"=> false,
            "employee.delete"=> false,
            "employee.create"=> false,
            "hr.user.list"=> false,
            "hr.user.show"=> false,
            "hr.user.edit"=> false,
            "hr.user.delete"=> false,
            "hr.user.create"=> false,
            "permission.list"=> false,
            "permission.show"=> false,
            "permission.edit"=> false,
            "permission.delete"=> false,
            "permission.create"=> false,
            "report.absensi"=> false,
            "report.ijin"=> false,
            "report.gaji"=> false,
            "setting.list"=> false,
            "setting.show"=> false,
            "setting.edit"=> false,
            "setting.delete"=> false,
            "setting.create"=> false,
            "slideshow.list"=> false,
            "slideshow.show"=> false,
            "slideshow.edit"=> false,
            "slideshow.delete"=> false,
            "slideshow.create"=> false,
            "ijin.approval"=> false,
            "ijin.pengajuan"=> false
        ];
        $role->save();

		/*
		*  Adding Users & Roles
		*/
        $user = Sentinel::registerAndActivate(array(
            'id' => Uuid::generate()->string,
			'email'    => 'admin@cahayabaru.com',
			'username'    => 'admin',
			'fullname' => 'admin',
			'password' => 'qweasd',
			'status' => 'ACTIVE',
            'phone_number' => '081234567',
            'address' => 'Jalan Admin',
            'birthplace' => 'Surabaya',
            'birthday' => '2000-01-01',
            'gender' => 'male',
            'gaji' => 3000000,
            'cuti_sisa' => 14,
		));
		$role = Sentinel::findRoleByName('Super Admin');
		$role->users()->attach($user);
		
		/*
		*  Adding Users & Roles
		*/
        $user = Sentinel::registerAndActivate(array(
            'id' => Uuid::generate()->string,
			'email'    => 'hr1@cahayabaru.com',
			'username'    => 'hr1',
			'fullname' => 'Human Resource 1',
			'password' => 'qweasd',
			'status' => 'ACTIVE',
            'phone_number' => '0811111111',
            'address' => 'Jalan HR',
            'birthplace' => 'Surabaya',
            'birthday' => '2000-01-02',
            'gender' => 'male',
            'gaji' => 3000000,
            'cuti_sisa' => 14,
		));
		$role = Sentinel::findRoleByName('HR');
		$role->users()->attach($user);


        /*
		*  Adding Employee
		*/
        $user = Sentinel::registerAndActivate(array(
            'id' => Uuid::generate()->string,
            'email'    => 'employee1@cahayabaru.com',
            'username'    => 'employee1',
            'fullname' => 'Employee 1',
            'password' => 'qweasd',
            'status' => 'ACTIVE',
            'phone_number' => '0812222222',
            'address' => 'Jalan Employee 1',
            'birthplace' => 'Surabaya',
            'birthday' => '2000-01-05',
            'gender' => 'female',
            'gaji' => 2000000,
            'cuti_sisa' => 14,
        ));
        $role = Sentinel::findRoleByName('Employee');
        $role->users()->attach($user);

        
        $user = Sentinel::registerAndActivate(array(
            'id' => Uuid::generate()->string,
            'email'    => 'employee2@cahayabaru.com',
            'username'    => 'employee2',
            'fullname' => 'Employee 2',
            'password' => 'qweasd',
            'status' => 'ACTIVE',
            'phone_number' => '081286765',
            'address' => 'Jalan Employee 2',
            'birthplace' => 'Surabaya',
            'birthday' => '2000-01-08',
            'gender' => 'male',
            'gaji' => 3000000,
            'cuti_sisa' => 14,
        ));
        $role = Sentinel::findRoleByName('Employee');
        $role->users()->attach($user);

        
        $user = Sentinel::registerAndActivate(array(
            'id' => Uuid::generate()->string,
            'email'    => 'employee3@cahayabaru.com',
            'username'    => 'employee3',
            'fullname' => 'Employee 3',
            'password' => 'qweasd',
            'status' => 'ACTIVE',
            'phone_number' => '0816151221',
            'address' => 'Jalan Employee 3',
            'birthplace' => 'Surabaya',
            'birthday' => '2000-01-10',
            'gender' => 'female',
            'gaji' => 3500000,
            'cuti_sisa' => 14,
        ));
        $role = Sentinel::findRoleByName('Employee');
        $role->users()->attach($user);

        
        $user = Sentinel::registerAndActivate(array(
            'id' => Uuid::generate()->string,
            'email'    => 'employee4@cahayabaru.com',
            'username'    => 'employee4',
            'fullname' => 'Employee 4',
            'password' => 'qweasd',
            'status' => 'ACTIVE',
            'phone_number' => '082233367',
            'address' => 'Jalan Employee 4',
            'birthplace' => 'Surabaya',
            'birthday' => '2000-01-01',
            'gender' => 'male',
            'gaji' => 3000000,
            'cuti_sisa' => 14,
        ));
        $role = Sentinel::findRoleByName('Employee');
        $role->users()->attach($user);

        
        $user = Sentinel::registerAndActivate(array(
            'id' => Uuid::generate()->string,
            'email'    => 'employee5@cahayabaru.com',
            'username'    => 'employee5',
            'fullname' => 'Employee 5',
            'password' => 'qweasd',
            'status' => 'ACTIVE',
            'phone_number' => '081234567',
            'address' => 'Jalan Employee 5',
            'birthplace' => 'Surabaya',
            'birthday' => '2000-01-21',
            'gender' => 'male',
            'gaji' => 4000000,
            'cuti_sisa' => 14,
        ));
        $role = Sentinel::findRoleByName('Employee');
        $role->users()->attach($user);
            \DB::commit();
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
            \DB::rollBack();
        }
		
    }
}
