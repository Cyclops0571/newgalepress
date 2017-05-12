<?php

namespace App\Mail;

use App\Models\PaymentAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Iyzipay\Model\Currency;

class PaymentChargedMailler extends Mailable implements ShouldQueue {

    use Queueable, SerializesModels;
    protected $data;
    protected $locale;

    /**
     * Create a new message instance.
     *
     * @param PaymentAccount $paymentAccount
     */
    public function __construct(PaymentAccount $paymentAccount)
    {
        $this->locale = app()->getLocale();
        $this->data['msg'] = trans('maillang.payment_successful_body', ['HOLDER' => $paymentAccount->Application->Name, 'PRICE' => $paymentAccount->Application->Price, 'CURRENCY' => Currency::TL]);
        $this->data['subject'] = trans('maillang.payment_successful_subject');
        dump($this->data);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        app()->setLocale($this->locale);

        return $this->view('mail-templates.payment_charged_mail')
            ->with($this->data)
            ->subject($this->data['subject']);
    }
}
