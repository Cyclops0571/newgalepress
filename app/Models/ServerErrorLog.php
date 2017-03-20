<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ServerErrorLog
 *
 * @property int $ServerErrorLogsID
 * @property int $Header
 * @property string $Url
 * @property string $Parameters
 * @property string $ErrorMessage
 * @property string $StackTrace
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServerErrorLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServerErrorLog whereErrorMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServerErrorLog whereHeader($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServerErrorLog whereParameters($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServerErrorLog whereServerErrorLogsID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServerErrorLog whereStackTrace($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServerErrorLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ServerErrorLog whereUrl($value)
 * @mixin \Eloquent
 */
class ServerErrorLog extends Model
{
    protected $table = 'ServerErrorLog';
    protected  $primaryKey = 'ServerErrorLogID';
    public static $key = 'ServerErrorLogID';


    public function save(array $option = [])
    {
        $this->Parameters = json_encode($this->Parameters);
        return parent::save();
    }

    public static function logAndSave($header, $url, $message, $parameters = array(), $stackTrace = "")
    {
        $self = new self();
        $self->Header = $header;
        $self->Url = $url;
        $self->Parameters = $parameters;
        $self->ErrorMessage = $message;
        $self->StackTrace = $stackTrace;
    }

}
