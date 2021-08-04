<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UserLogger;
use Carbon\Carbon;
use App\User;

class Setting extends Model
{
    protected $fillable = [];
    protected $table = "settings";

    use UserLogger;
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
    public function getUpdatedByAttribute($id){
    	$user = User::find($id);
    	if($user)
    		return $user->username; 
    }
}
