<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SigninMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $body;

    /**
     * Create a new message instance.
     */
    public function __construct($subject,$body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }

    public function build()
    {
        return $this->subject('New Sign-in Detected') // Set the email subject
        ->view('emails.test') // Use the "emails.test" Blade template
        ->with([              // Pass data to the view
            'content' => $this->body,
        ]);
    }

}
