<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerWelcomeMailler extends Mailable
{

    public $data;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {

        $this->data = [
            'name' => $request->get('senderEmail', ''),
            'phone' => $request->get('phone', ''),
            'company' => $request->get('company', ''),
            'comment' => $request->get('comment', '')
        ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail-templates.contactForm')
            ->with($this->data);
    }
}
