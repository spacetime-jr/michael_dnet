<?php
namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;


class Ijin extends Model
{
    
    const CUTI = 'cuti';
    const CUTIGAJI = 'cuti potong gaji';
    const SAKIT = 'sakit';
    const PENDINGAPPROVAL = 'pending approval';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';
    
    protected $table = "ijin";
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function aprrover(){
        return $this->belongsTo('App\User', 'approved_by');
    }

    public function getStartDateAttribute($date)
    {
        if ($date)
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');
    }

    public function getEndDateAttribute($date)
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
