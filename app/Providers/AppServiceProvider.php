<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        app('Dingo\Api\Exception\Handler')->register(function (\Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException $exception) {
            $response = array('status' => 'error', 'code' => 200, 'message' => $exception->getMessage());
            return response()->json($response);
        });
        app('Dingo\Api\Exception\Handler')->register(function (\Symfony\Component\HttpKernel\Exception\HttpException $exception) {
            $response = array('status' => 'error', 'code' => 500, 'message' => $exception->getMessage());
            return response()->json($response, 500);
        });
        Validator::extend('lesser_than_field', function($attribute, $value, $parameters, $validator) {
          $min_field = $parameters[0];
          $data = $validator->getData();
          $min_value = $data[$min_field];
          return $value < $min_value;
        });   

        Validator::replacer('lesser_than_field', function($message, $attribute, $rule, $parameters) {
          return str_replace(':field', $parameters[0], $message);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }
}
