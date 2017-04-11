<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentAdminRemainderMailler extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $data = [];
    protected $locale;

    /**
     * Create a new message instance.
     *
     * @param $WarningMailSet
     */
    public function __construct($WarningMailSet)
    {
        $this->locale = app()->getLocale();
        $msg = "Ödeme yapmayan müşteri listesi: \r\n";
        foreach ($WarningMailSet as $WarningMail) {
            $customer = Customer::find($WarningMail["customerID"]);
            $msg .= "CustomerID: " . $customer->CustomerID . " İsim: " . $customer->CustomerName
                . " Son Ödeme Tarihi: " . date("d-m-Y", strtotime($WarningMail["last_payment_day"]))
                . " Uyarı Mail Seviyesi: " . $WarningMail["warning_mail_phase"]
                . " Hata Sebebi:" . $WarningMail["error_reason"] . "\r\n";
        }
        $this->data['msg'] = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app()->setLocale($this->locale);
        return $this->view('mail-templates.payment_admin_reminder_mail')
            ->with($this->data)
            ->subject("Gale Press Ödeme Hatırlatma Maili");
    }
}
