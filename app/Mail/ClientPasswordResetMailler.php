<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientPasswordResetMailler extends Mailable implements ShouldQueue {

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
        $subject = trans('clients.login_email_subject', ['Application' => $this->client->Application->Name]);
        $url = route('mobile_reset_password_form',
            [
                'ApplicationID' => $this->client->Application->ApplicationID,
                'email'         => $this->client->Email,
                'code'          => $this->client->PWRecoveryCode,
            ]
        );
        $data['msg'] = trans('clients.login_email_message',
            [
                'Application' => $this->client->Application->Name,
                'firstname'   => $this->client->Name,
                'lastname'    => $this->client->Surname,
                'username'    => $this->client->Username,
                'url'         => $url,
            ]
        );
        $data['title'] = $subject;
        $data['url'] = $url;
        $this->view('mail-templates.client_password_reset_mail')
            ->with($data)
            ->subject($subject);

    }
}
