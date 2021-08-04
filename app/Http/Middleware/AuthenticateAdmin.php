<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Sentinel;

class AuthenticateAdmin
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
		if(!Sentinel::guest()){
			if($_SERVER['REQUEST_URI'] == '/login'){
				return redirect()->route('dashboard');
			}
		}

		return $next($request);
    }
}
