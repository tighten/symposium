<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewUser extends Notification
{
    protected $user;

    protected $ip;

    public function __construct($user, $ip)
    {
        $this->user = $user;
        $this->ip = $ip;
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
                    ->title('New user signup')
                    ->content("{$this->user->username}\n{$this->user->email}\n{$this->ip}")
                    ->timestamp(Carbon::now());
            });
    }
}
