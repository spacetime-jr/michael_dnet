<?php

namespace Modules\Users\Entities;

use App\Traits\UserLogger;
use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressUser extends Model
{
    use UserLogger;

    // Const address type
    const PRIMARY = 'primary';
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';

    protected $guarded = ['id'];
    protected $table = "address_users";

    protected $hidden = ['created_at', 'created_by', 'updated_at', 'updated_by'];


    public function user(){
        return $this->belongsTo('App\User', 'user_id');
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
