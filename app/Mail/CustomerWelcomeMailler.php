<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerWelcomeMailler extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $locale;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
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
        return $this->view('mail-templates.customer_welcome_mail')
            ->with(['user' => $this->user])
            ->subject(trans('common.welcome_email_title'));
    }
}
