<?php

namespace App;

use App\Traits\SchoolLogger;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Laravel\Passport\HasApiTokens;
use League\OAuth2\Server\Exception\OAuthServerException;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\Uuids;
use App\Traits\UserLogger;
use Cartalyst\Sentinel\Roles\RoleInterface;

class User extends Authenticatable
{
    use LogsActivity;
    use Uuids;
    use HasApiTokens;
    use UserLogger;
    use SchoolLogger;

    protected static $logAttributes = [
        
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


    const MALE = 'LAKI-LAKI';
    const FEMALE = 'PEREMPUAN';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected  $fillable = [
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
        'password', 'remember_token',
    ];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "user {$eventName}";
    }

    public function medias()
    {
        return $this->hasMany('\App\Media', 'user_id');
    }

    public function creator(){
          return $this->hasOne('\App\User', 'id', 'created_by');
    }
    
    public function getBirthdayAttribute($date)
    {
        if ($date)
            return date('Y-m-d', strtotime($date));
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

    public function byPassportCustomRequest(Request $request)
    {
        return null;
    }

    public function ijin()
    {
        return $this->hasMany('\Modules\Users\Entities\Ijin', 'user_id');
    }

    public function absensi()
    {
        return $this->hasMany('\Modules\Users\Entities\Absensi', 'user_id');
    }

    /**
     * The Eloquent roles model name.
     *
     * @var string
     */
    protected static $rolesModel = 'Cartalyst\Sentinel\Roles\EloquentRole';

    /**
     * The Eloquent persistences model name.
     *
     * @var string
     */
    protected static $persistencesModel = 'Cartalyst\Sentinel\Persistences\EloquentPersistence';

    /**
     * The Eloquent activations model name.
     *
     * @var string
     */
    protected static $activationsModel = 'Cartalyst\Sentinel\Activations\EloquentActivation';

    /**
     * The Eloquent reminders model name.
     *
     * @var string
     */
    protected static $remindersModel = 'Cartalyst\Sentinel\Reminders\EloquentReminder';

    /**
     * The Eloquent throttling model name.
     *
     * @var string
     */
    protected static $throttlingModel = 'Cartalyst\Sentinel\Throttling\EloquentThrottle';

    /**
     * Returns an array of login column names.
     *
     * @return array
     */
    public function getLoginNames()
    {
        return $this->loginNames;
    }

    /**
     * Returns the roles relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(static::$rolesModel, 'role_users', 'user_id', 'role_id')->withTimestamps();
    }

    /**
     * Returns the persistences relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function persistences()
    {
        return $this->hasMany(static::$persistencesModel, 'user_id');
    }

    /**
     * Returns the activations relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activations()
    {
        return $this->hasMany(static::$activationsModel, 'user_id');
    }

    /**
     * Returns the reminders relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reminders()
    {
        return $this->hasMany(static::$remindersModel, 'user_id');
    }

    /**
     * Returns the throttle relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function throttle()
    {
        return $this->hasMany(static::$throttlingModel, 'user_id');
    }

    /**
     * Get mutator for the "permissions" attribute.
     *
     * @param  mixed $permissions
     * @return array
     */
    public function getPermissionsAttribute($permissions)
    {
        return $permissions ? json_decode($permissions, true) : [];
    }

    /**
     * Set mutator for the "permissions" attribute.
     *
     * @param  mixed $permissions
     * @return void
     */
    public function setPermissionsAttribute(array $permissions)
    {
        $this->attributes['permissions'] = $permissions ? json_encode($permissions) : '';
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * {@inheritDoc}
     */
    public function inRole($role)
    {
        if ($role instanceof RoleInterface) {
            $roleId = $role->getRoleId();
        }

        foreach ($this->roles as $instance) {
            if ($role instanceof RoleInterface) {
                if ($instance->getRoleId() === $roleId) {
                    return true;
                }
            } else {
                if ($instance->getRoleId() == $role || $instance->getRoleSlug() == $role) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function generatePersistenceCode()
    {
        return str_random(32);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserId()
    {
        return $this->getKey();
    }

    /**
     * {@inheritDoc}
     */
    public function getPersistableId()
    {
        return $this->getKey();
    }

    /**
     * {@inheritDoc}
     */
    public function getPersistableKey()
    {
        return $this->persistableKey;
    }

    /**
     * {@inheritDoc}
     */
    public function setPersistableKey($key)
    {
        $this->persistableKey = $key;
    }

    /**
     * {@inheritDoc}
     */
    public function setPersistableRelationship($persistableRelationship)
    {
        $this->persistableRelationship = $persistableRelationship;
    }

    /**
     * {@inheritDoc}
     */
    public function getPersistableRelationship()
    {
        return $this->persistableRelationship;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserLogin()
    {
        return $this->getAttribute($this->getUserLoginName());
    }

    /**
     * {@inheritDoc}
     */
    public function getUserLoginName()
    {
        return reset($this->loginNames);
    }

    /**
     * {@inheritDoc}
     */
    public function getUserPassword()
    {
        return $this->password;
    }

    /**
     * Returns the roles model.
     *
     * @return string
     */
    public static function getRolesModel()
    {
        return static::$rolesModel;
    }

    /**
     * Sets the roles model.
     *
     * @param  string $rolesModel
     * @return void
     */
    public static function setRolesModel($rolesModel)
    {
        static::$rolesModel = $rolesModel;
    }

    /**
     * Returns the persistences model.
     *
     * @return string
     */
    public static function getPersistencesModel()
    {
        return static::$persistencesModel;
    }

    /**
     * Sets the persistences model.
     *
     * @param  string $persistencesModel
     * @return void
     */
    public static function setPersistencesModel($persistencesModel)
    {
        static::$persistencesModel = $persistencesModel;
    }

    /**
     * Returns the activations model.
     *
     * @return string
     */
    public static function getActivationsModel()
    {
        return static::$activationsModel;
    }

    /**
     * Sets the activations model.
     *
     * @param  string $activationsModel
     * @return void
     */
    public static function setActivationsModel($activationsModel)
    {
        static::$activationsModel = $activationsModel;
    }

    /**
     * Returns the reminders model.
     *
     * @return string
     */
    public static function getRemindersModel()
    {
        return static::$remindersModel;
    }

    /**
     * Sets the reminders model.
     *
     * @param  string $remindersModel
     * @return void
     */
    public static function setRemindersModel($remindersModel)
    {
        static::$remindersModel = $remindersModel;
    }

    /**
     * Returns the throttling model.
     *
     * @return string
     */
    public static function getThrottlingModel()
    {
        return static::$throttlingModel;
    }

    /**
     * Sets the throttling model.
     *
     * @param  string $throttlingModel
     * @return void
     */
    public static function setThrottlingModel($throttlingModel)
    {
        static::$throttlingModel = $throttlingModel;
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));

        if ($this->exists && !$isSoftDeleted) {
            $this->activations()->delete();
            $this->persistences()->delete();
            $this->reminders()->delete();
            $this->roles()->detach();
            $this->throttle()->delete();
        }

        return parent::delete();
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
