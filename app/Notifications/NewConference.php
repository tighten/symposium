<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\SlackAttachment;

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
        return (new SlackMessage)
            ->attachment(function (SlackAttachment $attachment) {
                $attachment
                    ->title('New conference created')
                    ->content("{$this->conference->title}\n{$this->conference->link}")
                    ->timestamp(Carbon::now());
            });
    }
}
