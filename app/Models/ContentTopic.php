<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContentTopic
 *
 * @property int $ContentTopicID
 * @property int $ContentID
 * @property int $TopicID
 * @property-read \App\Models\Content $Content
 * @property-read \App\Models\Topic $Topic
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentTopic whereContentID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentTopic whereContentTopicID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentTopic whereTopicID($value)
 * @mixin \Eloquent
 */
class ContentTopic extends Model
{
    public $timestamps = false;
    protected $table = 'ContentTopic';
    protected $primaryKey = 'ContentTopicID';
    public static $key = 'ContentTopicID';

    public function Content() {
        return $this->hasOne(Content::class, 'ContentID');
    }

    public function Topic() {
        return $this->hasOne(Topic::class, 'TopicID');
    }
}
