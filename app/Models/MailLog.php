<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MailLog
 *
 * @property int $MailLogID
 * @property int $MailID
 * @property int $UserID
 * @property int $Arrived
 * @property string $created_at
 * @property string $updated_at
 * @property int $StatusID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MailLog whereMailLogID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MailLog whereMailID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MailLog whereUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MailLog whereArrived($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MailLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MailLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MailLog whereStatusID($value)
 * @mixin \Eloquent
 */
class MailLog extends Model
{
    public $timestamps = false;
    protected $table = 'MailLog';
    protected $primaryKey = 'MailLogID';
}
