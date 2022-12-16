<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class ConferenceImporterInactive extends Notification
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
                    ->title('Conference importer may be inactive')
                    ->content(
                        'The last successful run was at ' . cache('conference_importer_last_ran_at')
                    )
                    ->timestamp(Carbon::now());
            });
    }
}
