<?php

namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientRegisteredMailler extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $password;
    /** @var Client  */
    protected $client;
    protected $locale;

    /**
     * Create a new message instance.
     *
     * @param Client $client
     * @param $password
     */
    public function __construct(Client $client, $password)
    {
        $this->locale = app()->getLocale();
        $this->client = $client;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app()->setLocale($this->locale);

        $subject = '';
        $msg = __('clients.registered_email_message', [
                'Application' => $this->client->Application->Name,
                'firstname'   => $this->client->Name,
                'lastname'    => $this->client->Surname,
                'username'    => $this->client->Username,
                'pass'        => $this->password,
            ]
        );

        $data = [
            'msg'    => $msg,
            'title' => trans('clients.registered_email_subject', ['Application' => $this->client->Application->Name])
        ];
        return $this->view('mail-templates.client_registered_mail')
            ->with($data)
            ->subject(trans('clients.registered_email_subject', ['Application' => $this->client->Application->Name]));
    }
}
