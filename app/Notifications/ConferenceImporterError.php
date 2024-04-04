<?php

namespace App\Notifications;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class ConferenceImporterError extends Notification
{
    use Queueable;

    protected $message;

    public function __construct(Exception $exception)
    {
        $this->message = $exception->getMessage();
    }

    public function via($notifiable): array
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage())
            ->attachment(function ($attachment) {
                $attachment
                    ->title('Conference importer encountered an error')
                    ->content("Message: {$this->message}")
                    ->timestamp(Carbon::now());
            });
    }
}
