<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends Model
{
    const CHECKEDIN = 'checkedin';
    const CHECKEDOUT = 'checkedout';
    protected $table = "absensi";
    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'created_by', 'updated_at', 'updated_by'];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getCheckinAttribute($date)
    {
        if ($date)
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
    }

    public function getCheckoutAttribute($date)
    {
        if ($date)
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
    }
}
