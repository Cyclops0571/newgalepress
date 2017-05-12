<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Crop
 *
 * @property int $CropID
 * @property int $ObjectType
 * @property int $ParentID
 * @property int $Width
 * @property int $Height
 * @property string $Type
 * @property bool $Radius
 * @property string $Description
 * @property string $Watermark
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crop whereCropID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crop whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crop whereHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crop whereObjectType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crop whereParentID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crop whereRadius($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crop whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crop whereWatermark($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Crop whereWidth($value)
 * @mixin \Eloquent
 */
class Crop extends Model
{
    public $timestamps = false;
    protected $table = 'Crop';
    protected $primaryKey = 'CropID';
    public static $key = 'CropID';
}
