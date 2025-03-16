<?php

namespace App\Notifications;


use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class ActivityCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $activity;

    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    public function via(): array
    {
        return ['mail','broadcast','database']; // Store in DB and broadcast real-time
    }

    public function toArray(): array
    {
        return [
            'message' => 'A new activity has been created: ' . $this->activity->activity_name,
            'activity_id' => $this->activity->id,
            'event_id' => $this->activity->events->id
        ];
    }

}
