<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LoginHistory
 *
 * @property int $id
 * @property int $UserID
 * @property string $action
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LoginHistory whereAction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LoginHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LoginHistory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LoginHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LoginHistory whereUserID($value)
 * @mixin \Eloquent
 */
class LoginHistory extends Model
{
    protected $table = 'login_histories';
    public function logout(User $user)
    {
        $this->UserID = $user->UserID;
        $this->action = 'logout';
        $this->save();
    }

    public function login(User $user) {
        $this->UserID = $user->UserID;
        $this->action = 'login';
        $this->save();
    }
}
