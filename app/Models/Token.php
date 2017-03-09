<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Token
 *
 * @property int $TokenID
 * @property int $CustomerID
 * @property int $ApplicationID
 * @property string $UDID
 * @property string $ApplicationToken
 * @property string $DeviceToken
 * @property string $DeviceType
 * @property int $StatusID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Token whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Token whereApplicationToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Token whereCustomerID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Token whereDeviceToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Token whereDeviceType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Token whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Token whereTokenID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Token whereUDID($value)
 * @mixin \Eloquent
 */
class Token extends Model
{
    public static $key = 'TokenID';
    protected $primaryKey = 'TokenID';
    protected $table = 'Token';
    public $timestamps;
    //public static $timestamps = false;

}
