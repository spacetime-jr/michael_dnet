<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Parser;
use Modules\Users\Exceptions\InvalidCredentialsException;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Foundation\Application;

class LoginProxy
{
    const REFRESH_TOKEN = 'refreshToken';

    private $auth;

    private $cookie;

    private $db;

    private $request;

    public function __construct(Application $app)
    {
        $this->auth = $app->make('auth');
        $this->cookie = $app->make('cookie');
        $this->db = $app->make('db');
        $this->request = $app->make('request');
    }

    /**
     * Attempt to create an access token using user credentials
     *
     * @param string $email
     * @param string $password
     * @param null $type
     * @return array
     */
    public function attemptLogin($email, $password, $type = null)
    {
        $user = User::where('email', $email)->first();
        if(empty($user))
            $user = User::where('username','=',$email)->first();

        if (!is_null($user)) {
            return $this->proxy('password', [
                'username' => $email,
                'password' => $password,
                'type'     => $type
            ]);
        }

        throw new InvalidCredentialsException();
    }



    /**
     * Attempt to refresh the access token used a refresh token that
     * has been saved in a cookie
     */
    public function attemptRefresh()
    {
        $refreshToken = $this->request->cookie(self::REFRESH_TOKEN);

        return $this->proxy('refresh_token', [
            'refresh_token' => $refreshToken
        ]);
    }

    /**
     * Proxy a request to the OAuth server.
     *
     * @param string $grantType what type of grant type should be proxied
     * @param array $data the data to send to the server
     */
    public function proxy($grantType, array $data = [])
    {
        $data = array_merge($data, [
            'client_id' => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
            'grant_type' => $grantType
        ]);

        $http = new Client;

        $response = $http->post(env('APP_URL') . '/oauth/token', [
            'form_params' => $data,
        ]);



        if ($response->getStatusCode() != 200) {
            throw new InvalidCredentialsException();
        }

        $data = json_decode($response->getBody());

        // Create a refresh token cookie
        $this->cookie->queue(
            self::REFRESH_TOKEN,
            $data->refresh_token,
            864000, // 10 days
            null,
            null,
            false,
            true // HttpOnly
        );

        return [
            'access_token' => $data->access_token,
            'refresh_token' => $data->refresh_token,
            'expires_in' => $data->expires_in
        ];
    }

    /**
     * Logs out the user. We revoke access token and refresh token.
     * Also instruct the client to forget the refresh cookie.
     */
    public function logout($bearerToken)
    {
        $id = (new Parser())->parse($bearerToken)->getHeader('jti');
        $accessToken= Auth::user()->tokens->find($id);

        $refreshToken = DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        $this->cookie->queue($this->cookie->forget(self::REFRESH_TOKEN));
    }
}