<?php

namespace App;

use App\Models\Application;
use App\Models\Customer;
use App\Models\LoginHistory;
use DB;
use eStatus;
use eUserTypes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $readNotifications
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $unreadNotifications
 * @mixin \Eloquent
 * @property int $UserID
 * @property int $UserTypeID
 * @property int $CustomerID
 * @property string $Username
 * @property string $FbUsername
 * @property mixed $Password
 * @property string $FirstName
 * @property string $LastName
 * @property string $Email
 * @property string $FbEmail
 * @property string $FbAccessToken
 * @property string $Timezone
 * @property string $PWRecoveryCode
 * @property string $PWRecoveryDate
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @property string $ConfirmCode
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUserTypeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCustomerID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFbUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFbEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFbAccessToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereTimezone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePWRecoveryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePWRecoveryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereProcessTypeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereConfirmCode($value)
 * @property string $remember_token
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @property-read \App\Models\Customer $Customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Application[] $Applications
 */
class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    protected $table = 'User';
    protected $primaryKey = 'UserID';
    private static $key = 'UserID';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Username', 'Email', 'Password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'Password', 'remember_token',
    ];

    /**
     * @param $username
     * @return array|null|\stdClass|User
     */
    public static function getByUsername($username)
    {
        return self::getQuery()->where('Username', '=', $username)
            ->where('StatusID', '=', eStatus::Active)
            ->first();
    }

    public function getAuthPassword()
    {
        return $this->Password;
    }

    /**
     * @return LoginHistory|\Illuminate\Database\Eloquent\Builder
     */
    public function lastLoginDate()
    {
        $loginHistory = $this->hasMany('App\Models\LoginHistory', self::$key)
            ->getQuery()
            ->where('action', 'login')
            ->orderBy('id', 'Desc')->first();
        if ($loginHistory) {
            return $loginHistory->created_at;
        }

        return date('Y:m:d H:i');
    }


    /**
     * @return Application[]|\Illuminate\Database\Eloquent\Collection
     */
    public function expiringApps()
    {
        return $this->Applications()->getQuery()
            ->where('ExpirationDate', '>=', DB::raw('CURDATE()'))
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Applications()
    {
        return $this->hasMany(Application::class, 'CustomerID');
    }


    /**
     *
     * @param int $statusID
     * @return Application[]|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function Application($statusID = eStatus::Active)
    {

        if ($this->UserTypeID == eUserTypes::Manager) {
            $applications = Application::where('StatusID', '=', $statusID)->get();
        } else {
            $applications = $this->Applications()->getQuery()->where('StatusID', '=', $statusID)->get();
        }
        return $applications;
    }

    /**
     *
     * @return Customer|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'CustomerID');
    }

}
