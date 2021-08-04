<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     basePath="/v1",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="API Documentation",
 *         description="This is a sample description for current API",
 *         termsOfService="",
 *         @SWG\License(
 *             name="Private License",
 *         )
 *     )
 * )
 */

class ApiController extends Controller
{
    public function getUsers(){
		$users = \App\User::all();
		return $users;
	}
	

	public function getUserInfo(Request $request){
		$user = \App\User::find($request['id']);
		return $user;
	}
	

	public function updateUserInfo(Request $request){
		return $request['user_data'];
	}
}
