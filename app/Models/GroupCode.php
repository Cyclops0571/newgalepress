<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GroupCode
 *
 * @property int $GroupCodeID
 * @property string $GroupName
 * @property int $DisplayOrder
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCode whereGroupCodeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCode whereGroupName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCode whereDisplayOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCode whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCode whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCode whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCode whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCode whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCode whereProcessTypeID($value)
 * @mixin \Eloquent
 */
class GroupCode extends Model
{
    public $timestamps = false;
    protected $table = 'GroupCode';
    protected $primaryKey = 'GroupCodeID';
}
