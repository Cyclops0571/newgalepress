<?php

namespace App\Models;

use App\Scopes\StatusScope;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Topic
 *
 * @property int $TopicID
 * @property string $Name
 * @property int $Order
 * @property int $StatusID
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Application[] $Application
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Topic whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Topic whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Topic whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Topic whereTopicID($value)
 * @mixin \Eloquent
 */
class Topic extends Model
{
    public $timestamps = false;
    protected $table = 'Topic';
    protected $primaryKey  = 'TopicID';
    public static $key = 'TopicID';

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(new StatusScope);
    }

    public function getServiceData() {
        return array('id' => $this->TopicID, 'name' => $this->Name);
    }

    public function Application() {
        return $this->belongsToMany(Application::class, 'ApplicationTopic', 'TopicID', 'ApplicationID');
    }
}
