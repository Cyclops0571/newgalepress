<?php

namespace App\Models;

use App\Scopes\StatusScope;
use Auth;
use DateTime;
use eProcessTypes;
use eStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PageComponentProperty
 *
 * @mixin \Eloquent
 * @property int $PageComponentPropertyID
 * @property int $PageComponentID
 * @property string $Name
 * @property string $Value
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponentProperty whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponentProperty whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponentProperty whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponentProperty wherePageComponentID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponentProperty wherePageComponentPropertyID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponentProperty whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponentProperty whereProcessTypeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponentProperty whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponentProperty whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponentProperty whereValue($value)
 */
class PageComponentProperty extends Model {


    public $timestamps = false;
    protected $primaryKey = 'PageComponentPropertyID';
    protected $table = 'PageComponentProperty';
    public static $key = 'PageComponentPropertyID';

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(new StatusScope);
    }


    public static function batchInsert($pageComponentID, array $nameValueSet)
    {
        foreach ($nameValueSet as $name => $value)
        {
            $pcp = new PageComponentProperty();
            $pcp->PageComponentID = $pageComponentID;
            $pcp->Name = $name;
            $pcp->Value = $value;
            $pcp->save();
        }
    }

    public function save(array $options = [])
    {
        if ($this->isClean())
        {
            return true;
        }
        $userID = -1;
        if (Auth::user())
        {
            $userID = Auth::user()->UserID;
        }

        if ((int)$this->PageComponentPropertyID == 0)
        {
            $this->DateCreated = new DateTime();
            $this->CreatorUserID = $userID;
            $this->StatusID = eStatus::Active;
            $this->ProcessTypeID = eProcessTypes::Insert;
        } else
        {
            $this->ProcessTypeID = eProcessTypes::Update;
        }

        $this->ProcessUserID = $userID;
        $this->ProcessDate = new DateTime();
        parent::save($options);
    }

}
