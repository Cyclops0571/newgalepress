<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactFormMailler extends Mailable implements ShouldQueue
{

    public $data;
    protected $locale;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->locale = app()->getLocale();
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
        app()->setLocale($this->locale);
        return $this->view('mail-templates.contact_form_mail')
            ->with($this->data)->subject(trans('common.welcome_email_title'));
    }
}
