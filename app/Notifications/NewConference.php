<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewConference extends Notification
{
    protected $conference;

    public function __construct($conference)
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
            ->attachment(function (SlackAttachment $attachment) {
                $attachment
                    ->title('New conference created')
                    ->content("{$this->conference->title}\nAPPROVE HERE: {$this->conference->link}")
                    ->timestamp(Carbon::now());
            });
    }
}
