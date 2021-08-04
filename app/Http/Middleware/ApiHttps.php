<?php

namespace App\Http\Middleware;

use Closure;

class ApiHttps
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
        $response = array('status' => 'error', 'code' => 405, 'data' => 'Not Allowed!');
        if (!$request->secure() && env('APP_ENV') === 'prod') {
            return \Response::json($response);
        }

        return $next($request);
    }
}
