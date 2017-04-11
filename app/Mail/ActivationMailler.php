<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivationMailler extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
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

        $data = [
            'name'    => $this->user->FirstName,
            'surname' => $this->user->LastName,
            'url'     => route('common_confirmemail_get', ['email' => $this->user->Email, 'code' => $this->user->ConfirmCode]),
        ];
        return $this->view('mail-templates.activation_mail')
            ->with($data)
            ->subject(trans('common.confirm_email_title'));
    }
}
