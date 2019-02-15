<?php

namespace App\Notifications;

use App\Conference;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CFPIsOpen extends Notification
{
    use Queueable;

    /**
     * @var Conference
     */
    public $conference;

    /**
     * Create a new notification instance.
     *
     * @param Conference $conference
     */
    public function __construct(Conference $conference)
    {
        $this->conference = $conference;
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
            ->subject('New Open CFP')
            ->line('The CFP for '.$this->conference->title.' is now open.')
            ->action('Visit CFP', $this->conference->cfp_url);
    }
}
