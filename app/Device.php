<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\SystemLogger;
use App\Traits\Uuids;

class Device extends Model
{
    use Uuids;
    use SystemLogger;

    protected $table = 'devices';

    protected $fillable = ['device_token', 'device_type', 'app_version', 'session_token'];
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo('\App\User', 'user_id');
    }

    public function getLastLoginAttribute($date)
    {
        if ($date)
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
    }

    public function getCreatedAtAttribute($date)
    {
        if ($date)
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        if ($date)
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
    }
}
