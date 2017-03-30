<?php

namespace App\Models;

use App\Scopes\StatusScope;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Component
 *
 * @property int $ComponentID
 * @property int $DisplayOrder
 * @property string $Name
 * @property string $Description
 * @property string $Class
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Component whereClass($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Component whereComponentID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Component whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Component whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Component whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Component whereDisplayOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Component whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Component whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Component whereProcessTypeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Component whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Component whereStatusID($value)
 * @mixin \Eloquent
 */
class Component extends Model
{


    public $timestamps = false;
    protected $table = 'Component';
    protected $primaryKey = 'ComponentID';
    public static $key = 'ComponentID';
    const ComponentVideo = 1;
    const ComponentAudio = 2;
    const ComponentMap = 3;
    const ComponentLink = 4;
    const ComponentWeb = 5;
    const ComponentTooltip = 6;
    const ComponentScroller = 7;
    const ComponentSlideShow = 8;
    const Component360 = 9;
    const ComponentBookmark = 10;
    const ComponentAnimation = 11;

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(new StatusScope());
    }

    public function getPath() {
        return public_path('files/components/' . $this->Class );
    }

    public function getZipPath() {
        return $this->getPath() . '/files.zip';
    }


}
