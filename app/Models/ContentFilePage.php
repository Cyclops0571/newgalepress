<?php

namespace App\Models;

use App\Scopes\ContentFilePageScope;
use Auth;
use Common;
use DateTime;
use DB;
use eProcessTypes;
use eStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContentFilePage
 *
 * @property int $ContentFilePageID
 * @property int $ContentFileID
 * @property int $No
 * @property int $OperationStatus
 * @property float $Width
 * @property float $Height
 * @property string $FilePath
 * @property string $FileName
 * @property string $FileName2
 * @property int $FileSize
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PageComponent[] $PageComponents
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereContentFilePageID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereContentFileID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereOperationStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereFilePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereFileName2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereProcessTypeID($value)
 * @mixin \Eloquent
 */
class ContentFilePage extends Model
{

    const Video = 1;
    const Audio = 2;
    const Map = 3;
    const Link = 4;
    const Web = 5;
    const Tooltip = 6;
    const Scroller = 7;
    const SlideShow = 8;
    const slide360 = 9;
    const Bookmark = 10;
    const Animation = 11;
    const OperationContinues = 1;
    const OperationAvailable = 0;
    public $timestamps = false;
    protected $table = 'ContentFilePage';
    public static $key = 'ContentFilePageID';
    protected $primaryKey = 'ContentFilePageID';

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new ContentFilePageScope);
    }

    /**
     * @param $contentFileID
     * @param $pageNo
     * @return ContentFilePage
     */
    public static function getPage($contentFileID, $pageNo)
    {
        return ContentFilePage::where('ContentFileID', '=', $contentFileID)
            ->where('No', '=', $pageNo)
            ->where('StatusID', '=', eStatus::Active)
            ->first();
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if (!$this->isDirty()) {
            return true;
        }
        $userID = -1;
        if (Auth::user()) {
            $userID = Auth::user()->UserID;
        }

        if ($this->Height == 0 || $this->Width == 0) {
            $prevFilePage = $this->previousContentFilePage();
            if ($prevFilePage) {
                if ($this->Height == 0) {
                    $this->Height = $prevFilePage->Height;
                }
                if ($this->Width == 0) {
                    $this->Width = $prevFilePage->Width;
                }
            }
        }

        if ((int)$this->ContentFilePageID == 0) {
            $this->DateCreated = new DateTime();
            $this->CreatorUserID = $userID;
            $this->StatusID = eStatus::Active;
            $this->ProcessTypeID = eProcessTypes::Insert;
        } else {
            $this->ProcessTypeID = eProcessTypes::Update;
        }

        $this->ProcessUserID = $userID;
        $this->ProcessDate = new DateTime();
        return parent::save($options);
    }

    /**
     * @return ContentFilePage
     */
    public function previousContentFilePage()
    {
        return ContentFilePage::where('ContentFileID', '=', $this->ContentFileID)
            ->where('No', '=', ($this->No - 1))
            ->first();
    }

    public function PageComponents()
    {
        return $this->hasMany(PageComponent::class, self::$key)->where('StatusID', '=', eStatus::Active);
    }


    private function removePageComponent($pageComponentID)
    {
        PageComponentProperty::where('PageComponentID', 'IN', DB::raw('(SELECT `PageComponentID` FROM `PageComponent` WHERE `PageComponentID`='
                . $pageComponentID . ' AND `ContentFilePageID`=' . $this->ContentFilePageID . ' AND `StatusID`=1)'))
            ->where('StatusID', '=', eStatus::Active)
            ->update(
                array(
                    'StatusID' => eStatus::Deleted,
                    'ProcessUserID' => Auth::user()->UserID,
                    'ProcessDate' => new DateTime(),
                    'ProcessTypeID' => eProcessTypes::Update
                )
            );

        PageComponent::getQuery()
            ->where('PageComponentID', '=', $pageComponentID)
            ->where('ContentFilePageID', '=', $this->ContentFilePageID)
            ->where('StatusID', '=', eStatus::Active)
            ->update(
                array(
                    'StatusID' => eStatus::Deleted,
                    'ProcessUserID' => Auth::user()->UserID,
                    'ProcessDate' => new DateTime(),
                    'ProcessTypeID' => eProcessTypes::Update
                )
            );
    }

    public function getPageComponentPropertiesAndValues($postData, $componentOrder)
    {
        $properties = array();
        foreach ($postData as $name => $value) {
            if (Common::startsWith($name, 'comp-' . $componentOrder)) {
                $name = str_replace('comp-' . $componentOrder . '-', "", $name);
                if (!in_array($name, PageComponent::$ignoredProperties)) {
                    $properties[$name] = $value;
                }
            }
        }
        return $properties;
    }

    public function nextPage()
    {
        return ContentFilePage::where('ContentFileID', '=', $this->ContentFileID)
            ->where('No', '=', $this->No + 1)
            ->where('StatusID', '=', eStatus::Active)
            ->first();
    }

}
