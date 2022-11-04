<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class ConferenceImporterStarted extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage())
            ->attachment(function ($attachment) {
                $attachment
                    ->title('Conference importer started')
                    ->timestamp(Carbon::now());
            });
    }
}
