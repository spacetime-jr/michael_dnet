<?php
/**
 * Created by PhpStorm.
 * User: vdjke
 * Date: 10/28/2016
 * Time: 6:31 p.m.
 */

namespace App\Providers;
use Dingo\Api\Routing\Route;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthManager;
use Dingo\Api\Auth\Provider\Authorization;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class GuardServiceProvider extends Authorization
{
    /**
     * Illuminate authentication manager.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * The guard driver name.
     *
     * @var string
     */
    protected $guard = 'api';

    /**
     * Create a new basic provider instance.
     *
     * @param \Illuminate\Auth\AuthManager $auth
     */
    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth->guard($this->guard);
    }

    /**
     * Authenticate request with a Illuminate Guard.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Dingo\Api\Routing\Route $route
     *
     * @return mixed
     */
    public function authenticate(Request $request, Route $route)
    {
        if (! $user = $this->auth->user()) {
            throw new UnauthorizedHttpException(
                get_class($this),
                'Unable to authenticate with invalid API key and token.'
            );
        }

        return $user;
    }

    /**
     * Get the providers authorization method.
     *
     * @return string
     */
    public function getAuthorizationMethod()
    {
        return 'Bearer';
    }
}