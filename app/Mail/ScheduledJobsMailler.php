<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScheduledJobsMailler extends Mailable
{
    use Queueable, SerializesModels;
    protected $locale;
    protected $data = [];

    /**
     * Create a new message instance.
     *
     * @param $msg
     */
    public function __construct($msg)
    {
        $this->locale = app()->getLocale();
        $this->data['url'] = '';
        $this->data['content'] = $msg;
        $this->data['title'] = '';

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app()->setLocale($this->locale);
        return $this->view('mail-templates.scheduled_job_mail')
            ->with($this->data);
    }
}
