<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;


/**
 * App\Models\City
 *
 * @property int $CityID
 * @property string $CityName
 * @property bool $StatusID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereCityID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereCityName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereStatusID($value)
 * @mixin \Eloquent
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