<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Module;

class ModuleController extends Controller
{
    public function index(){
		$availables = Module::getByStatus(1);
		foreach($availables as $av){
			$av->status = 'enable';
		}

		$unavailables = Module::getByStatus(0);
		foreach($unavailables as $av){
			$av->status = 'disable';
		}

		$modules = array_merge($availables, $unavailables);

		return view('module.index', [
			'modules' => $modules
		]);
	}

	public function changeStatus($name, $status){
		$cmd = "Module::find('".$name."')->".$status."();";
		eval($cmd);
		return redirect()->route('module.index')->with('success', 'Module has been changed.');
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
