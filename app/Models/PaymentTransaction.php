<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Iyzipay\Model\BasicThreedsInitialize;

/**
 * App\Models\PaymentTransaction
 *
 * @property int $PaymentTransactionID
 * @property int $PaymentAccountID
 * @property int $CustomerID
 * @property string $transaction_id
 * @property int $external_id
 * @property int $reference_id
 * @property string $state
 * @property float $amount
 * @property string $currency
 * @property string $request
 * @property string $response
 * @property string $response3d
 * @property int $paid
 * @property int $mail_send
 * @property string $errorCode
 * @property string $errorMessage
 * @property string $errorGroup
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\PaymentAccount $PaymentAccount
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereCurrency($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereCustomerID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereErrorCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereErrorGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereErrorMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereExternalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereMailSend($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction wherePaid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction wherePaymentAccountID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction wherePaymentTransactionID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereReferenceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereRequest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereResponse($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereResponse3d($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereTransactionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentTransaction extends Model
{


    protected $table = 'PaymentTransaction';
    protected $primaryKey = 'PaymentTransactionID';

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function PaymentAccount() {
        return $this->belongsTo(PaymentAccount::class, 'PaymentAccountID');
    }

    /**
     * @param \Iyzipay\Model\BasicPayment|\Iyzipay\Model\BasicThreedsPayment $basicPayment
     */
    public function updateTransaction($basicPayment) {
        $this->response = $basicPayment->getRawResult();
        $this->transaction_id = $basicPayment->getPaymentTransactionId();
        $this->external_id = $basicPayment->getPaymentId();
        $this->state = $basicPayment->getStatus();
        $this->amount = $basicPayment->getPaidPrice();
        $this->currency = $basicPayment->getCurrency();
        $this->paid = (int)($basicPayment->getStatus() == "success");
        $this->errorCode = $basicPayment->getErrorCode();
        $this->errorMessage = $basicPayment->getErrorMessage();
        $this->errorGroup = $basicPayment->getErrorGroup();
        $this->save();
    }

    public function update3dTransaction(BasicThreedsInitialize $basicThreeDsInitialize) {
        $this->response3d = $basicThreeDsInitialize->getRawResult();
        $this->state = $basicThreeDsInitialize->getStatus();
        $this->errorCode = $basicThreeDsInitialize->getErrorCode();
        $this->errorMessage = $basicThreeDsInitialize->getErrorMessage();
        $this->errorGroup = $basicThreeDsInitialize->getErrorGroup();
        $this->save();
    }
}
