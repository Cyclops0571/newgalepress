<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Content
 *
 * @property int $ContentID
 * @property int $ApplicationID
 * @property int $OrderNo
 * @property string $Name
 * @property string $Detail
 * @property string $MonthlyName
 * @property string $PublishDate
 * @property int $IsUnpublishActive
 * @property string $UnpublishDate
 * @property int $CategoryID
 * @property int $IsProtected
 * @property string $Password
 * @property int $IsBuyable
 * @property float $Price
 * @property int $CurrencyID
 * @property int $IsMaster
 * @property bool $Orientation
 * @property string $Identifier
 * @property int $AutoDownload
 * @property int $Approval
 * @property int $Blocked
 * @property int $Status
 * @property int $RemoveFromMobile
 * @property int $Version
 * @property int $PdfVersion
 * @property int $CoverImageVersion
 * @property int $TotalFileSize
 * @property int $TopicStatus
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereContentID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereOrderNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereMonthlyName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content wherePublishDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereIsUnpublishActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereUnpublishDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereCategoryID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereIsProtected($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereIsBuyable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereCurrencyID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereIsMaster($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereOrientation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereIdentifier($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereAutoDownload($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereApproval($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereBlocked($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereRemoveFromMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content wherePdfVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereCoverImageVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereTotalFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereTopicStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereProcessTypeID($value)
 * @mixin \Eloquent
 */
class Content extends Model
{
    public $timestamps = false;
    protected $table = 'Content';
    protected $primaryKey = 'ContentID';
}
