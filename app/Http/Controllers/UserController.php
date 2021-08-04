<?php

namespace App\Http\Controllers;

use App\Reference;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Sentinel;

class UserController extends Controller
{
    public function index(){
		$users = User::all();
		
		return view('user.index', [
			'users' => $users
		]);
	}
	
	public function changeStatus($status, $user_id){
		if($status == User::INACTIVE){
			$us = \Sentinel::findById($user_id);
			\Activation::remove($us);
		}else if($status == User::ACTIVE){
			$us = \Sentinel::findById($user_id);
			$activation = \Activation::exists($us);
			
			if(!\Activation::completed($us) && $activation){
				\Activation::complete($us, $activation->code);
			}else if(!$activation){
				$ac = \Activation::create($us);
				\Activation::complete($us, $ac->code);
			}
		}
		
		$user = User::find($user_id);
		$user->status = $status;
		$user->save();
		
		// firing on UpdateData event
		$log = array(
			'desc' => 'changing user activation type'
		);
		event(new \App\Events\UpdateData($user, $log));
		
		return redirect()->route('user.index')->with('success', 'Status has been changed successfully.');
	}
	
	public function create(){
		$users = User::all();
		$roles = \Sentinel::getRoleRepository()->all();


        return view('user.create', [
			'users' => $users,
			'roles' => $roles,
		]);
	}
	
	public function store(Request $request){
		$data = $request->all();
		$user = Sentinel::registerAndActivate($data);
		$role = Sentinel::findRoleBySlug($data['role']);
		$role->users()->attach($user);
		$user->status = User::ACTIVE;

		$user->save();
		
		// firing on UpdateData event
		$log = array(
			'desc' => 'adding new user'
		);
		event(new \App\Events\UpdateData($user, $log));
		
		return redirect()->route('user.index')->with('success', 'User has been changed added successfully.');
	}
	
	public function show(){
		
	}
	
	public function edit($id){
		$user = \Sentinel::findById($id);
		$roles = \Sentinel::getRoleRepository()->all();
		$currentRole = \Sentinel::findById($user->id)->roles[0]->slug;
		//dd($currentRole);
		return view('user.edit',['user' => $user,'roles' => $roles, 'currentRole' => $currentRole]);
	}
	
	public function update($id, Request $request){
		$data = $request->all();
		$customer_data = \Sentinel::findUserById($id);
		//dd($customer->customerDetail[0]);
		if($data['password']){
			$dataUpdate = array(
				'fullname' => $data['fullname'],
				'email' => $data['email'],
				'password' => $data['password'], 
				'status' => $data['status']
			);
		}else{
			$dataUpdate = array(
				'fullname' => $data['fullname'],
				'email' => $data['email'],
				'status' => $data['status']
			);
		}
		\Sentinel::update($customer_data, $dataUpdate);

		$role = \Sentinel::findRoleBySlug($data['role']);
		$old_role = \Sentinel::findRoleBySlug($data['old_role']);
		$old_role->users()->detach($customer_data);
		$role->users()->attach($customer_data);
		
		return redirect()->route('user.index')->with('success', 'User has been changed added successfully.');
	}
	
	public function destroy($user_id){
		$user = User::find($user_id);
		$user->delete();
		
		event(new \App\Events\UpdateData($user, array('desc' => 'removing user')));
		
		return array(
			'url' => route('user.index'),
			'message' => 'User has been removed.'
		);
	}
}
