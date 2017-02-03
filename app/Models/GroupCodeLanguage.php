<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GroupCodeLanguage
 *
 * @property int $GroupCodeID
 * @property int $LanguageID
 * @property string $DisplayName
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCodeLanguage whereGroupCodeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCodeLanguage whereLanguageID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupCodeLanguage whereDisplayName($value)
 * @mixin \Eloquent
 */
class GroupCodeLanguage extends Model
{
    public $timestamps = false;
    protected $table = 'GroupCodeLanguage';
    protected $primaryKey = 'GroupCodeID';
}
