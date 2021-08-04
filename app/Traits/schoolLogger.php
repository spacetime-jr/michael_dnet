<?php
namespace App\Traits;

use Webpatser\Uuid\Uuid;
use Auth;
trait SchoolLogger
{

    /**
    * Boot function from laravel.
    */
    protected static function bootSchoolLogger()
    {
//        parent::boot();

        static::creating(function ($model) {
            $user = Auth::user();

            if(!empty($user->sekolah_id))
                $model->sekolah_id = $user->sekolah_id;
        });

        static::updating(function ($model) {
            $user = Auth::user();

            if(!empty($user->sekolah_id))
                $model->sekolah_id = $user->sekolah_id;
        });
    }
}