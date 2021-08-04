<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use \App\User;

class RoleController extends Controller
{
    public function index(){
		$roles = \Sentinel::getRoleRepository();
		$roles = $roles->all();
		
		return view('role.index', [
			'roles' => $roles
		]);
	}
	
	public function create(){
		
	}
	
	public function store(){
		
	}
	
	public function show(){
		
	}
	
	public function edit(){
		
	}
	
	public function update(){
		
	}
	
	public function destroy(){
		
	}
}
