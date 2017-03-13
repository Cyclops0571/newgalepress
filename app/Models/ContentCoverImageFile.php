<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContentCoverImageFile
 *
 * @property int $ContentCoverImageFileID
 * @property int $ContentFileID
 * @property string $DateAdded
 * @property string $FilePath
 * @property string $SourceFileName
 * @property string $FileName
 * @property string $FileName2
 * @property int $FileSize
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereContentCoverImageFileID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereContentFileID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereDateAdded($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereFilePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereSourceFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereFileName2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentCoverImageFile whereProcessTypeID($value)
 * @mixin \Eloquent
 */
class ContentCoverImageFile extends Model
{


    public $timestamps = false;
    protected $table = 'ContentCoverImageFile';
    protected $primaryKey = 'ContentCoverImageFileID';
    public static $key = 'ContentCoverImageFileID';

}