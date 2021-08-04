<?php

namespace App;

use App\Traits\SchoolLogger;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use League\OAuth2\Server\Exception\OAuthServerException;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\Uuids;
use App\Traits\UserLogger;

class UserSentinel extends \Cartalyst\Sentinel\Users\EloquentUser
{
    use LogsActivity;
    use Uuids;
    use UserLogger;
    use SchoolLogger;

    protected static $logAttributes = [
        'fullname',
        'phone_number',
        'birthplace',
        'birthday',
        'gender',
        'address',
        'name',
        'email',
        'password',
        'nisn',
        'status',
        'sekolah_id',
        'grade',
        'balance',
        'points',
        'password_changed',
        'profile_picture_url',
    ];

//    protected static $logAttributes = ["*"];

    protected static $ignoreChangedAttributes = ['last_login','updated_at','updated_by'];

    protected static $logOnlyDirty = true;

    public $incrementing = false;

    const ACTIVE = 'ACTIVE';
    const INACTIVE = 'INACTIVE';
    const PENDING = 'PENDING';
    const BANNED = 'BANNED';
    const SUSPENDED = 'SUSPENDED';
    const DELETED = 'DELETED';
    const NOTAPPROVED = 'NOTAPPROVED';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname',
        'first_name',
        'last_name',
        'username',
        'phone_number',
        'birthplace',
        'birthday',
        'gender',
        'address',
        'name',
        'email',
        'password',
        'birthplace',
        'birthday',
        'gender',
        'gaji',
        'status',
    ];

    protected $loginNames = ['email', 'username'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot'
    ];

    public function medias()
    {
        return $this->hasMany('\App\Media', 'user_id');
    }

    public function ijin()
    {
        return $this->hasMany('\Modules\Users\Entities\Ijin', 'user_id');
    }

    public function absensi()
    {
        return $this->hasMany('\Modules\Users\Entities\Absensi', 'user_id');
    }


    public function getLastActivityAttribute($date)
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

    public function creator(){
          return $this->hasOne('\App\User', 'id', 'created_by');
    }

    public function byPassportCustomRequest(Request $request)
    {
        try {
            if (!empty($request->username)) {
                if($this->username == $request->username)
                    return $this;
            }
        } catch (\Exception $e) {
            throw OAuthServerException::accessDenied($e->getMessage());
        }
        return null;
    }

    /**
     * Custom field request for passport matching parameter (username/email), so user can login with both email or username
     */
    public function findForPassport($username){
        $user = $this->where('email', $username)->first();
        if(empty($user))
            $user = $this->where('username','=',$username)->first();
        return $user;
    }
    
}
