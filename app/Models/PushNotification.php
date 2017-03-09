<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PushNotification
 *
 * @property int $PushNotificationID
 * @property int $CustomerID
 * @property int $ApplicationID
 * @property string $NotificationText
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @property-read \App\Models\Application $Application
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotification whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotification whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotification whereCustomerID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotification whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotification whereNotificationText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotification whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotification whereProcessTypeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotification whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotification wherePushNotificationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PushNotification whereStatusID($value)
 * @mixin \Eloquent
 */
class PushNotification extends Model
{
    public $timestamps = false;
    protected $table = 'PushNotification';
    protected $primaryKey ='PushNotificationID';

    public function Application() {
        return $this->belongsTo(Application::class, "ApplicationID");
    }
}
