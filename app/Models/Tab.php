<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tab
 *
 * @property int $TabID
 * @property int $ApplicationID
 * @property string $TabTitle
 * @property string $Url
 * @property string $InhouseUrl
 * @property string $IconUrl
 * @property int $Status
 * @property int $StatusID
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tab whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tab whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tab whereIconUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tab whereInhouseUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tab whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tab whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tab whereTabID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tab whereTabTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tab whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tab whereUrl($value)
 * @mixin \Eloquent
 */
class Tab extends Model
{
    protected $table = 'Tabs';
    protected $primaryKey = 'TabID';
    protected static $key = 'TabID';


    public static function getGalepresTabs() {
        return array(
            "StoreLocator" => __('common.map_title')
        );
    }

    public function urlForService() {
        if (!empty($this->Url) && $this->Url != "http://") {
            $url = $this->Url;
        } else {
            switch ($this->InhouseUrl) {
                case "StoreLocator":
                    $url = \URL::to("/maps/webview/" . $this->ApplicationID);
                    break;
                default :
                    $url = \URL::to('/');
            }
        }
        return $url;
    }
}
