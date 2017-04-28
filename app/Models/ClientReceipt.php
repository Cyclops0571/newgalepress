<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ClientReceipt
 *
 * @property int $ClientReceiptID
 * @property int $ClientID
 * @property string $SubscriptionID
 * @property string $Platform
 * @property string $PackageName
 * @property string $SubscriptionType
 * @property string $SubscriptionStartDate
 * @property string $SubscriptionEndDate
 * @property string $Receipt
 * @property string $MarketResponse
 * @property int $StatusID
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Client $Client
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ClientReceipt whereClientID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ClientReceipt whereClientReceiptID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ClientReceipt whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ClientReceipt whereMarketResponse($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ClientReceipt wherePackageName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ClientReceipt wherePlatform($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ClientReceipt whereReceipt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ClientReceipt whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ClientReceipt whereSubscriptionEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ClientReceipt whereSubscriptionID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ClientReceipt whereSubscriptionStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ClientReceipt whereSubscriptionType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ClientReceipt whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClientReceipt extends Model
{


    protected $table = 'ClientReceipt';
    protected $primaryKey = 'ClientReceiptID';
    public static $key = 'ClientReceiptID';

    public function save(array $options = [])
    {
        if ($this->isClean()) {
            return true;
        }

        parent::save();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Client()
    {
        return $this->belongsTo(Client::class, 'ClientID');
    }

}
