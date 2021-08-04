<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Chrisbjr\ApiGuard;
use Log;
use ApiGuardAuth;
//use Chrisbjr\ApiGuard\Repositories\ApiKeyRepository;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Relogin with Auth, so we can user Auth instead
        $user = app('Dingo\Api\Auth\Auth')->user();
        if(!empty($user)){
            $user->last_login = date('Y-m-d H:i:s');
            $user->save();
            \Auth::loginUsingId($user->id);
        }

        return $next($request);
    }
}