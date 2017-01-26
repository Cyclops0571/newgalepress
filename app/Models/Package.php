<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Package
 *
 * @property int $PackageID
 * @property string $Name
 * @property bool $Interactive
 * @property int $MaxActivePDF
 * @property int $MonthlyQuote
 * @property int $Bandwidth
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Package wherePackageID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Package whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Package whereInteractive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Package whereMaxActivePDF($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Package whereMonthlyQuote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Package whereBandwidth($value)
 * @mixin \Eloquent
 */
class Package extends Model
{
    public $timestamps = false;
    public $table = 'Package';
    public $primaryKey = 'PackageID';
}
