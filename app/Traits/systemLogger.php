<?php
namespace App\Traits;

use Webpatser\Uuid\Uuid;
use Auth;

trait SystemLogger
{

    /**
     * Boot function from laravel.
     */
    protected static function bootSystemLogger()
    {
//        parent::boot();

        static::created(function ($model) {
            $model->created_by = 'system';
        });

        static::updating(function ($model) {
            $model->updated_by = 'system';
        });
    }
}