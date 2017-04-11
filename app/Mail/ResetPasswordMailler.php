<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordMailler extends Mailable {

    use Queueable, SerializesModels;
    /** @var User */
    protected $user;
    protected $locale;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @internal param $locale
     */
    public function __construct(User $user)
    {
        $this->locale = app()->getLocale();
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        app()->setLocale($this->locale);
        $applications = $this->user->Application();
        $recoveryLink = route('common_resetmypassword_get',
            ['email' => $this->user->Email, 'code' => $this->user->PWRecoveryCode]
        );
        $msg = trans('common.login_email_message', [
                'Application' => $applications[0]->Name,
                'firstname'   => $this->user->FirstName,
                'lastname'    => $this->user->LastName,
                'username'    => $this->user->Username,
                'url'         => $recoveryLink,
            ]
        );


        //571571
        return $this->view('mail-templates.reset_password_mail')
            ->with(compact('msg'))
            ->subject(trans('common.login_email_subject'));
    }
}
