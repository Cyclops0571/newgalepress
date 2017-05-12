<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Requestt
 *
 * @property int $RequestID
 * @property int $RequestTypeID
 * @property int $CustomerID
 * @property int $ApplicationID
 * @property int $ContentID
 * @property int $ContentFileID
 * @property int $ContentCoverImageFileID
 * @property string $RequestDate
 * @property string $IP
 * @property string $DeviceType
 * @property int $DeviceOS 1 ios, 2 android, 3 windows mobile, 4 blackbarry, 5 linux
 * @property int $FileSize
 * @property int $DataTransferred
 * @property int $Percentage
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereContentCoverImageFileID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereContentFileID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereContentID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereCustomerID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereDataTransferred($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereDeviceOS($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereDeviceType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereIP($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt wherePercentage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereProcessTypeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereRequestDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereRequestID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereRequestTypeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Requestt whereStatusID($value)
 * @mixin \Eloquent
 */
class Requestt extends Model
{
    const IOS = 1;
    const ANDROID = 2;
    const WINDOWS = 3;
    const BLACKBARRY = 4;
    const LINUX = 5;

    protected $primaryKey = 'RequestID';
    public $timestamps = false;
    protected $table = 'Request';
    public static $key = 'RequestID';


    public function save(array $options = array()) {
        if(strpos($this->DeviceType, 'iPhone') !== FALSE) {
            $this->DeviceOS = self::IOS;
        } else if (strpos($this->DeviceType, 'iPad') !== FALSE) {
            $this->DeviceOS = self::IOS;
        } else if (strpos($this->DeviceType, 'iPod') !== FALSE) {
            $this->DeviceOS = self::IOS;
        } else if (strpos($this->DeviceType, 'Android') !== FALSE) {
            $this->DeviceOS = self::ANDROID;
        } else if (strpos($this->DeviceType, 'Windows') !== FALSE) {
            $this->DeviceOS = self::WINDOWS;
        } else if (strpos($this->DeviceType, 'BlackBerry') !== FALSE) {
            $this->DeviceOS = self::BLACKBARRY;
        } else if (strpos($this->DeviceType, 'Linux') !== FALSE) {
            $this->DeviceOS = self::LINUX;
        }

        parent::save($options);
    }
}