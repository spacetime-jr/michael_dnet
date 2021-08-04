<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;

class AuthController extends Controller
{
	public function __construct(){
		// $checkpoint = new \App\Checkpoint\LegalCheckpoint;
		// \Sentinel::addCheckpoint('LegalCheckpoint', $checkpoint);
	}
	
    public function login(Request $request){
		$input = $request->all();
		$resp = Sentinel::authenticateAndRemember($input);
		if(!$resp){
			return redirect()->guest('login')->with('error', 'Wrong username/password combination.');
		}else{
            \Auth::loginUsingId($resp->id);
            activity('auth')
                ->performedOn($resp)
                ->causedBy($resp->id)
                ->log('login admin');

		    if(!empty($request->redirect)){
		        if(!\Route::has($request->redirect))
                    return redirect()->guest('login')->with('error', 'Redirect URL not found');
                return redirect()->route($request->redirect);
            }else{
                if ($resp->hasAccess(['admin.login'])){
//                    activity('auth')->log('login admin');
                    return redirect()->route('dashboard');
                }else{
                    return redirect()->guest('login')->with('error', 'You do not have access to this page.');
                }
            }

		}
	}
	
	public function logout(){
	    $user = \Auth::user();
		Sentinel::logout();
		\Auth::logout();

        activity('auth')
            ->performedOn($user)
            ->causedBy($user->id)
            ->log('logout admin');
//		activity('auth')->log('logout admin');
		return redirect()->guest('login')->with('success', "You've successfully logged out.");
	}
}
