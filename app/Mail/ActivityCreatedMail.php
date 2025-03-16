<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActivityCreatedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $activity;
    /**
     * Create a new message instance.
     */
    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    public function build()
    {
        return $this->subject('New Activity Created') // Set the email subject
        ->view('emails.test') // Use the "emails.test" Blade template
        ->with([              // Pass data to the view
            'content' => $this->activity,
        ]);
    }



    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
