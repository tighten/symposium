<?php

namespace App\Notifications;

use App\Models\ConferenceIssue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class ConferenceIssueReported extends Notification implements ShouldQueue
{
    use Queueable;

    protected $issue;

    public function __construct(ConferenceIssue $issue)
    {
        $this->issue = $issue;
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
                    ->title("Issue reported: {$this->issue->conference->title}")
                    ->content("View issue: {$this->issue->link}")
                    ->timestamp(Carbon::now());
            });
    }
}
