<?php

namespace App\Models;

use App\Scopes\PageComponentScope;
use Auth;
use DateTime;
use eProcessTypes;
use eStatus;
use File;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PageComponent
 *
 * @property int $PageComponentID
 * @property int $ContentFilePageID
 * @property int $ComponentID
 * @property int $No
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponent wherePageComponentID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponent whereContentFilePageID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponent whereComponentID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponent whereNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponent whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponent whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponent whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponent whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponent whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PageComponent whereProcessTypeID($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Component $Component
 * @property-read \App\Models\ContentFilePage $ContentFilePage
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PageComponentProperty[] $PageComponentProperty
 */
class PageComponent extends Model
{
    public $timestamps = false;
    protected $table = 'PageComponent';
    protected $primaryKey = 'PageComponentID';
    public static $key = 'PageComponentID';

    public static $ignoredProperties = array('id', 'process', 'fileselected', 'posterimageselected', 'modaliconselected');

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(new PageComponentScope);
    }

    public function Component()
    {
        return $this->belongsTo(Component::class, 'ComponentID');
    }

    public function save(array $options = [])
    {
        if ($this->isClean()) {
            return true;
        }
        $userID = -1;
        if (Auth::user()) {
            $userID = Auth::user()->UserID;
        }

        if ((int)$this->PageComponentID == 0) {
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
     * @param ContentFile $newContentFile
     * @param ContentFile $oldContentFile
     */
    public function moveToNewContentFile(ContentFile $newContentFile, ContentFile $oldContentFile)
    {
        $myPath = '/output/comp_' . $this->PageComponentID;
        if (File::exists($oldContentFile->pdfFolderPathAbsolute() . $myPath)) {
            File::moveDirectory($oldContentFile->pdfFolderPathAbsolute() . $myPath, $newContentFile->pdfFolderPathAbsolute() . $myPath);
        }
        $myHtml = $myPath . '.html';
        if (File::exists($oldContentFile->pdfFolderPathAbsolute() . $myHtml)) {
            File::move($oldContentFile->pdfFolderPathAbsolute() . $myHtml, $newContentFile->pdfFolderPathAbsolute() . $myHtml);
        }
    }

    public function PageComponentProperty()
    {
        return $this->hasMany(PageComponentProperty::class, self::$key);
    }

    public function ContentFilePage() {
        return $this->belongsTo(ContentFilePage::class, 'ContentFilePageID');
    }

}
