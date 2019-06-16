<?php

namespace App\Mail\SMTP;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SMTPConfig extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config("app.name"))
                    ->subject('Hi There!!')
                    ->view('emails.smtp.default')
                    ->with(['body' => 'Email sending is working.']);
    }
}
