<?php

namespace App\Mail;

use App\Models\Application;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscriptionExpireMailler extends Mailable
{
    use Queueable, SerializesModels;
    public $lang;
    /**
     * @var Application
     */
    private $application;
    /**
     * @var
     */
    private $user;

    /**
     * Create a new message instance.
     * @param Application $application
     * @param $user
     */
    public function __construct($application, $user)
    {
        $this->application = $application;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        $app = $this->application;
        app()->setLocale($app->ApplicationLanguage);
        $user = $this->user;
        $expirationDate = new Carbon($app->ExpirationDate);
        $diff = $expirationDate->diff(Carbon::today());

        $subject = trans('maillang.subscription_expire_notice_subject');
        $replacements = [
            'FIRSTNAME'       => $user->FirstName,
            'LASTNAME'        => $user->LastName,
            'APPLICATIONNAME' => $app->Name,
            'REMAINIGDAYS'    => $diff->days,
        ];
        if ($diff->days > 0)
        {
            $msg = trans('maillang.subscription_expire_notice_15days_body', $replacements);
        } else
        {
            $msg = trans('maillang.subscription_expire_notice_0days_body', $replacements);
        }


        return $this->view('mail-templates.send_password_mail')
        ->with(['content' => $msg, 'title' => $subject])
        ->subject($subject);
    }
}
