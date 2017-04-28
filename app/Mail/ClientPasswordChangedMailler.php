<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientPasswordChangedMailler extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $client;
    protected $locale;

    /**
     * Create a new message instance.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->locale = app()->getLocale();
        $this->client = $client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app()->setLocale($this->locale);

        $subject = trans('clients.login_resetpassword_email_subject', ['Application' => $this->client->Application->Name,]);
        $data['msg'] = trans('clients.login_resetpassword_email_message', [
                'Application' => $this->client->Application->Name,
                'firstname'   => $this->client->Name,
                'lastname'    => $this->client->Surname,
                'username'    => $this->client->Username,
            ]
        );
        $data['subject'] = $subject;
        return $this->view('mail-templates.client_password_changed_mail')
            ->with($data)
            ->subject($subject);
    }
}
