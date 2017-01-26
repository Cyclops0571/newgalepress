<?php


namespace App\Models;

use DateTime;
use eStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Statistic
 *
 * @property int ServiceVersion
 * @property mixed UID
 * @property int Type
 * @property mixed Time
 * @property bool|string RequestDate
 * @property mixed Lat
 * @property mixed Long
 * @property mixed DeviceID
 * @property int CustomerID
 * @property int ApplicationID
 * @property int ContentID
 * @property int Page
 * @property mixed Param5
 * @property mixed Param6
 * @property mixed Param7
 * @property mixed StatisticID
 * @property DateTime DateCreated
 * @property int ProcessTypeID
 * @property int CreatorUserID
 * @property int StatusID
 * @property int ProcessUserID
 * @property DateTime ProcessDate
 * @property int $StatisticID
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
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereStatisticID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereServiceVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereUID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereRequestDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereLat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereLong($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereDistrict($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereQuarter($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereAvenue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereDeviceID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereCustomerID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereContentID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic wherePage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereParam5($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereParam6($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereParam7($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Statistic whereProcessTypeID($value)
 * @mixin \Eloquent
 */
class Statistic extends Model
{

    public $timestamps = false;
    protected $table = 'Statistic';
    protected $primaryKey = 'StatisticID';

    public function save(array $options = [])
    {
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


        if ($this->isClean()) {
            return true;
        }

        $validTypes = array(1, 2, 3, 10, 11, 12, 13, 14, 21, 22);
        if (!in_array($this->Type, $validTypes)) {
            throw new \Exception('Invalid file type!');
        }

        $userID = -1;
        if (\Auth::user()) {
            $userID = \Auth::user()->UserID;
        }

        if ((int)$this->StatisticID == 0) {
            $this->DateCreated = new DateTime();
            $this->CreatorUserID = $userID;
            $this->StatusID = eStatus::Active;
        }
        $this->ProcessUserID = $userID;
        $this->ProcessDate = new DateTime();
        parent::save();
    }

}
