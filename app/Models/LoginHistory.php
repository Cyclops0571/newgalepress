<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\LoginHistory
 *
 * @property int $id
 * @property int $UserID
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LoginHistory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LoginHistory whereUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LoginHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LoginHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LoginHistory extends Model
{
    //
}
