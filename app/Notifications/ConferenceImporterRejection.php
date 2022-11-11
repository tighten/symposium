<?php

namespace App\Notifications;

use App\Models\Conference;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class ConferenceImporterRejection extends Notification
{
    use Queueable;

    protected $conference;

    public function __construct(Conference $conference)
    {
        $this->conference = $conference;
    }

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage())
            ->attachment(function ($attachment) {
                $attachment
                    ->title('Conference importer rejected a conference')
                    ->action($conference->title, $conference->link)
                    ->timestamp(Carbon::now());
            });
    }
}
