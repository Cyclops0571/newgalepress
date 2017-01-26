<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentAccount
 *
 * @property int $PaymentAccountID
 * @property int $CustomerID
 * @property int $ApplicationID
 * @property string $email
 * @property string $phone
 * @property string $title
 * @property float $tckn
 * @property string $vergi_dairesi
 * @property float $vergi_no
 * @property int $CityID
 * @property int $kurumsal Kurumsal: 1 Bireysel: 0
 * @property string $address
 * @property int $payment_count
 * @property string $FirstPayment
 * @property string $last_payment_day
 * @property string $ValidUntil
 * @property int $WarningMailPhase 1: nazik uyari maili gitti 2: uyari maili gitti 3:tehtit maili gitti
 * @property string $card_token
 * @property string $cardToken
 * @property string $cardUserKey
 * @property string $bin Kartın ilk 6 hanesi
 * @property string $brand
 * @property string $cardType
 * @property string $cardAssociation
 * @property string $cardFamily
 * @property string $expiry_month
 * @property string $expiry_year
 * @property string $last_4_digits
 * @property string $holder
 * @property string $card_verification
 * @property int $mail_send
 * @property int $StatusID
 * @property string $selected_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount wherePaymentAccountID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereCustomerID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereTckn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereVergiDairesi($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereVergiNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereCityID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereKurumsal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount wherePaymentCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereFirstPayment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereLastPaymentDay($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereValidUntil($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereWarningMailPhase($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereCardToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereCardUserKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereBin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereBrand($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereCardType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereCardAssociation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereCardFamily($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereExpiryMonth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereExpiryYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereLast4Digits($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereHolder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereCardVerification($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereMailSend($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereSelectedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentAccount extends Model
{
    protected $table = 'PaymentAccount';
    protected $primaryKey = 'PaymentAccountID';

}
