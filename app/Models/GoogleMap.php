<?php

namespace App\Models;

use App\Scopes\StatusScope;
use eStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GoogleMap
 *
 * @property int $GoogleMapID
 * @property int $ApplicationID
 * @property string $Name
 * @property string $Address
 * @property string $Description
 * @property string $Latitude
 * @property string $Longitude
 * @property int $StatusID
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleMap whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleMap whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleMap whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleMap whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleMap whereGoogleMapID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleMap whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleMap whereLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleMap whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleMap whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoogleMap whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GoogleMap extends Model
{
    protected $table = 'GoogleMap';
    protected $primaryKey = 'GoogleMapID';
    public static $key = 'GoogleMapID';

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(new StatusScope);
    }


    public static function getSampleXmlUrl()
    {
        return "/files/sampleFiles/SampleMapExcel_" . app()->getLocale() . ".xls";
    }

    public function CheckOwnership($appID)
    {
        return $this->ApplicationID == $appID;
    }

    public function save(array $option = [])
    {
        if ($this->isClean()) {
            return true;
        }

        if (!$this->GoogleMapID) {
            $this->StatusID = eStatus::Active;
        }
        return parent::save($option);
    }

    public function Application() {
        $this->belongsTo(Application::class, 'ApplicationID');
    }
}
