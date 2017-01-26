<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ApplicationTopic
 *
 * @property int $ApplicationTopicID
 * @property int $ApplicationID
 * @property int $TopicID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApplicationTopic whereApplicationTopicID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApplicationTopic whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ApplicationTopic whereTopicID($value)
 * @mixin \Eloquent
 */
class ApplicationTopic extends Model
{
    public $timestamps = false;
    protected $table = 'ApplicationTopic';
    protected $primaryKey = 'ApplicationTopicID';
}
