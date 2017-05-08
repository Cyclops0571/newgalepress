<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StatisticGraff
 *
 * @property int $StatisticGraffID
 * @property int $ServiceVersion
 * @property string $UID
 * @property int $Type
 * @property string $RequestDate
 * @property string $Time
 * @property string $Lat
 * @property string $Long
 * @property string $Country
 * @property string $City
 * @property string $District
 * @property string $Quarter
 * @property string $Avenue
 * @property string $DeviceID
 * @property int $CustomerID
 * @property int $ApplicationID
 * @property int $ContentID
 * @property int $Page
 * @property string $Param5
 * @property string $Param6
 * @property string $Param7
 * @property string $selected_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereAvenue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereContentID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereCustomerID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereDeviceID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereDistrict($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereLong($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff wherePage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereParam5($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereParam6($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereParam7($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereQuarter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereRequestDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereSelectedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereServiceVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereStatisticGraffID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereUID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StatisticGraff whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StatisticGraff extends Model {

    public $timestamps = true;
    protected $table = 'StatisticGraff';
    protected $primaryKey = 'StatisticGraffID';
    public static $key = 'StatisticGraffID';

    public function save(array $options = [])
    {
        if ($this->isClean())
        {
            return true;
        }

        /*
        applicationActive = 1;
        applicationPassive = 2;
        applicationTerminated = 3;
        contentDownloaded = 10;
        contentUpdated = 11;
        contentOpened = 12;
        contentClosed = 13;
        contentDeleted = 14;
        pageOpenedPortrait = 21;
        pageOpenedLandscape = 22;
         */


        $validTypes = [1, 2, 3, 10, 11, 12, 13, 14, 21, 22];
        if (!in_array($this->Type, $validTypes))
        {
            throw new Exception('Invalid file type!');
        }
        parent::save($options);
    }
}
