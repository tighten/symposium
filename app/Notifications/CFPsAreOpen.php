<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CFPsAreOpen extends Notification
{
    use Queueable;

    public $conferences;

    /**
     * Create a new notification instance.
     *
     * @param $conferences an array or collection of conferences
     */
    public function __construct($conferences)
    {
        $this->conferences = $conferences;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Open CFPs')
            ->markdown('emails.open-cfps', [
                'conferences' => $this->conferences,
            ]);
    }
}
