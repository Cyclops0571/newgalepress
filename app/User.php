<?php

namespace App;

use App\Models\Application;
use App\Models\Customer;
use App\Models\LoginHistory;
use App\Scopes\StatusScope;
use Common;
use DB;
use eStatus;
use eUserTypes;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Application[] $Applications
 * @property-read \App\Models\Customer $Customer
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Query\Builder|\App\User whereConfirmCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCustomerID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFbAccessToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFbEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFbUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePWRecoveryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePWRecoveryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereProcessTypeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereTimezone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUserTypeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable {

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

    public static function userList($customerID = 0, $search = '', $sort = 'UserID', $sortDirection = 'desc')
    {


        $sql = '' .
            'SELECT '
            . 'u.CustomerID, '
            . '(SELECT DisplayName FROM `GroupCodeLanguage` WHERE GroupCodeID=u.UserTypeID AND '
            . 'LanguageID=' . Common::getLocaleId() . ') AS UserTypeName, '
            . 'u.FirstName, '
            . 'u.LastName, '
            . 'u.Email, '
            . 'u.UserID '
            . 'FROM `User` AS u '
            . 'WHERE u.StatusID=1';

        $rs = DB::table(DB::raw('(' . $sql . ') t'))
            ->where(function (Builder $query) use ($customerID, $search)
            {
                if ($customerID > 0)
                {
                    $query->where('CustomerID', '=', $customerID);
                }

                if (strlen(trim($search)) > 0)
                {
                    $query->where('UserTypeName', 'LIKE', '%' . $search . '%');
                    $query->orWhere('FirstName', 'LIKE', '%' . $search . '%');
                    $query->orWhere('LastName', 'LIKE', '%' . $search . '%');
                    $query->orWhere('Email', 'LIKE', '%' . $search . '%');
                    $query->orWhere('UserID', 'LIKE', '%' . $search . '%');
                }
            })
            ->orderBy($sort, $sortDirection);

        return $rs->paginate(config('custom.rowcount'));
    }

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(new StatusScope);
    }

    /**
     * @param $username
     * @return array|null|\stdClass|User
     */
    public static function getByUsername($username)
    {
        return self::where('Username', '=', $username)
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
        $loginHistory = $this->hasMany(LoginHistory::class, self::$key)
            ->getQuery()
            ->where('action', 'login')
            ->orderBy('id', 'Desc')->first();
        if ($loginHistory)
        {
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
        return $this->hasMany(Application::class, 'CustomerID', 'CustomerID');
    }


    /**
     *
     * @param int $statusID
     * @return Application[]|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function Application($statusID = eStatus::Active)
    {

        if ($this->UserTypeID == eUserTypes::Manager)
        {
            $applications = Application::withoutGlobalScopes()->where('StatusID', '=', $statusID)->get();
        } else
        {
            $applications = $this->Applications;
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

    public function __get($key)
    {
        switch ($key)
        {
            case 'email':
                return $this->Email;
            case 'name':
                return $this->FirstName . " " . $this->LastName;
        }

        return parent::__get($key);
    }

    public function isAdmin()
    {
        return $this->UserTypeID == eUserTypes::Manager;
    }

}
