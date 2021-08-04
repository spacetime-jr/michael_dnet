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
		/*
		*  Adding Roles
		*/
		$role = Sentinel::getRoleRepository()->createModel()->create([
			'name' => 'Super Admin',
			'slug' => 'superadmin',
		]);
		$role->permissions =[
            "admin.login" => true,
            "module.change" => true,
            "user.list" => true,
            "user.show" => true,
            "user.edit" => true,
            "user.delete" => true,
            "user.create" => true,
            "permission.list" => true,
            "permission.show" => true,
            "permission.edit" => true,
            "permission.delete" => true,
            "permission.create" => true,
            "report.list" => true,
            "report.show" => true,
            "report.edit" => true,
            "report.delete" => true,
            "report.create" => true,
		];
		$role->save();
		
		$role = Sentinel::getRoleRepository()->createModel()->create([
			'name' => 'HR',
			'slug' => 'hr',
		]);
		$role->permissions =[
            "admin.login" => true,
            "module.change" => true,
            "user.list" => true,
            "user.show" => true,
            "user.edit" => true,
            "user.delete" => true,
            "user.create" => true,
            "permission.list" => false,
            "permission.show" => false,
            "permission.edit" => false,
            "permission.delete" => false,
            "permission.create" => false,
            "report.list" => true,
            "report.show" => true,
            "report.edit" => true,
            "report.delete" => true,
            "report.create" => true,
		];
		$role->save();

        $role = Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Employee',
            'slug' => 'employee',
        ]);
        $role->permissions =[
            "admin.login" => true,
            "module.change" => false,
            "user.list" => false,
            "user.show" => false,
            "user.edit" => false,
            "user.delete" => false,
            "user.create" => false,
            "permission.list" => false,
            "permission.show" => false,
            "permission.edit" => false,
            "permission.delete" => false,
            "permission.create" => false,
            "report.list" => false,
            "report.show" => false,
            "report.edit" => false,
            "report.delete" => false,
            "report.create" => false,
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
        ));
        $role = Sentinel::findRoleByName('Employee');
        $role->users()->attach($user);
    }
}
