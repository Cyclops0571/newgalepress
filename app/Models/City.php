<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;


/**
 * App\Models\City
 *
 * @property int $CityID Description
 * @property int $CityName Description
 * @property int $StatusID Description
 * @mixin \Eloquent
 * @method static Builder|City whereCityID($value)
 * @method static Builder|City whereCityName($value)
 * @method static Builder|City whereStatusID($value)
 */
class City extends Model
{

    public $timestamps = false;
    protected $table = 'Cities';
    protected $primaryKey = 'CityID';

    //put your code here

    public static function all($orderyBy = "CityName", $sort = "ASC")
    {
        return City::orderBy($orderyBy, $sort)->get();
    }

}