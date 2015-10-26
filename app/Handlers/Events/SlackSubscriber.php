<?php namespace Symposium\Handlers\Events;

use Maknz\Slack\Facades\Slack;

class SlackSubscriber
{
    public function subscribe($events)
    {
        if (empty(Slack::getEndpoint())) {
            return;
        }

        $events->listen('new-signup', [$this, 'onNewSignup']);
        $events->listen('new-conference', [$this, 'onNewConference']);
    }

    public function onNewSignup($user)
    {
        Slack::send("*New user signup:*\n{$user->first_name} {$user->last_name}\n{$user->email}");
    }

    public function onNewConference($conference)
    {
        Slack::send("*New conference created:*\n{$conference->title}\n{$conference->link}");
    }
}
