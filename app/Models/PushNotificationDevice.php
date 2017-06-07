<?php

namespace App\Models;

use App\Scopes\StatusScope;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PushNotificationDevice
 *
 * @property int $PushNotificationDeviceID
 * @property int $PushNotificationID
 * @property int $TokenID
 * @property string $UDID
 * @property string $ApplicationToken
 * @property string $DeviceToken
 * @property string $DeviceType
 * @property int $Sent
 * @property int $ErrorCount
 * @property string $LastErrorDetail
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @property-read \App\Models\PushNotification $PushNotification
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereApplicationToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereDeviceToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereDeviceType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereErrorCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereLastErrorDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereProcessTypeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice wherePushNotificationDeviceID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice wherePushNotificationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereSent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereTokenID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotificationDevice whereUDID($value)
 * @mixin \Eloquent
 */
class PushNotificationDevice extends Model
{
    public $timestamps = false;
    protected $table = 'PushNotificationDevice';
    public static $key = 'PushNotificationDeviceID';
    protected $primaryKey = 'PushNotificationDeviceID';

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(new StatusScope());
    }

    public function PushNotification()
    {
        return $this->belongsTo(PushNotification::class, 'PushNotificationID');
    }

    /**
     * @return bool
     */
    public static function isUnsentNotificationExists() {
        $tmp = PushNotificationDevice::where('Sent',  0)
            ->where('ErrorCount',  0)
            ->where('DateCreated', '>=', date('Y-m-d'))
            ->first();
        if($tmp && $tmp->PushNotification) {
            return true;
        }
        return false;
    }
}
