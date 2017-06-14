<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplicationFormRequestMailler extends Mailable
{
    use Queueable, SerializesModels;
    protected $orderNo;
    protected $appName;
    protected $locale;

    /**
     * Create a new message instance.
     *
     */
    public function __construct($appName, $orderNo)
    {
        $this->locale = app()->getLocale();
        $this->appName = $appName;
        $this->orderNo = $orderNo;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        app()->setLocale($this->locale);
        $toEmail = [
            "info@galepress.com",
            "denizkaracali@gmail.com",
            "deniz.karacali@detaysoft.com",
            "ercan.solcun@detaysoft.com",
        ];

        if(app()->isLocal()) {
            $toEmail = ['srdsaygili@gmail.com'];
        }

        $subject = "Yeni Bir Uygulama Formu Gönderildi!";
        $msgTemplate = "Sayın Yetkili, <br/><br/> %s uygulaması için %s siparis numarasına ait uygulama formunu lütfen işleme alınız.";
        $msg = sprintf($msgTemplate, $this->appName, $this->orderNo);
        return $this->view('mail-templates.application_form_request_mail', ['subject' => $subject, 'content' => $msg])->to($toEmail)->subject($subject);
    }
}
