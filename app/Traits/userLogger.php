<?php
namespace App\Traits;

use Webpatser\Uuid\Uuid;
use Auth;
trait UserLogger
{

    /**
    * Boot function from laravel.
    */
    protected static function bootUserLogger()
    {
//        parent::boot();

        static::creating(function ($model) {
            $user = Auth::user();

            if($user)
                $model->created_by = $user->id;
        });

        static::updating(function ($model) {
            $user = Auth::user();

            if($user)
                $model->updated_by = $user->id;
        });
    }
}