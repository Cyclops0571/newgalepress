<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordMailler extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var User
     */
    protected $user;
    protected $locale;
    protected $pass;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user, $pass)
    {
        $this->locale = app()->getLocale();
        $this->user = $user;
        $this->pass = $pass;
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
        $subject = trans('common.login_resetpassword_email_subject', ['Application' => $applications[0]->Name,]);
        $msg = trans('common.login_resetpassword_email_message', [
                'Application' => $applications[0]->Name,
                'firstname'   => $this->user->FirstName,
                'lastname'    => $this->user->LastName,
                'username'    => $this->user->Username,
                'pass'        => $this->pass,
            ]
        );
        return $this->view('mail-templates.send_password_mail')
            ->with(['content' => $msg, 'title' => $subject])
            ->subject($subject)
            ->to($this->user->Email, $this->user->FirstName . ' ' . $this->user->LastName);

    }
}
