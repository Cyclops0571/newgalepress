<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ErrorMailler extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $locale;
    protected $data;

    /**
     * Create a new message instance.
     *
     * @param $msg
     * @internal param string $locale
     */
    public function __construct($msg)
    {
        $this->locale = app()->getLocale();
        $this->data = [];
        $this->data['msg'] = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app()->setLocale($this->locale);
        dump($this->data);
        return $this->view('mail-templates.error_mail')
            ->with($this->data)
            ->subject(trans('common.task_subject'));
    }
}
