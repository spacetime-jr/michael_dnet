<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Sentinel;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Sentinel::guest()){

//            if($_SERVER['REQUEST_URI'] == '/'){
//                return redirect()->route('error');
//            }

			return redirect()->guest('login')->with('error','Anda harus login terlebih dahulu');
		}else{
			$user = Sentinel::getUser();
            if(!$user->hasAccess('admin.login')){
                Sentinel::logout($user);
                return redirect()->guest('login')->with('error','Anda tidak mempunyai akses untuk mengakses halaman ini');
            }
			Auth::loginUsingId($user->id);

            if($_SERVER['REQUEST_URI'] == '/login'){
                return redirect()->route('dashboard');
		    }
        }

		return $next($request);
    }
}
