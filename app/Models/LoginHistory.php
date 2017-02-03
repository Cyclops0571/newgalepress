<?php

namespace App\Models;

use App\User;
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
 * @property string $action
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LoginHistory whereAction($value)
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
