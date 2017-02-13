<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContentCategory
 *
 * @property int $ContentID
 * @property int $CategoryID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCategory whereContentID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCategory whereCategoryID($value)
 * @mixin \Eloquent
 */
class ContentCategory extends Model
{
    public $timestamps = false;
    protected $table = 'ContentCategory';
    protected $primaryKey = 'ContentID';
    public static $key = 'ContentID';
}
