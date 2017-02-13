<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Topic
 *
 * @property int $TopicID
 * @property string $Name
 * @property int $Order
 * @property int $StatusID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Topic whereTopicID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Topic whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Topic whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Topic whereStatusID($value)
 * @mixin \Eloquent
 */
class Topic extends Model
{
    public $timestamps = false;
    protected $table = 'Topic';
    protected $primaryKey  = 'TopicID';
    public static $key = 'TopicID';

    public function getServiceData() {
        return array('id' => $this->TopicID, 'name' => $this->Name);
    }
}
