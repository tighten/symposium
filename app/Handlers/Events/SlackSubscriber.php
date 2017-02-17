<?php

namespace App\Handlers\Events;

use Illuminate\Support\Facades\App;
use Maknz\Slack\Facades\Slack;

class SlackSubscriber
{
    public function subscribe($events)
    {
        if (empty(Slack::getEndpoint()) || App::environment('local')) {
            return;
        }

        $events->listen('new-signup', [$this, 'onNewSignup']);
        $events->listen('new-conference', [$this, 'onNewConference']);
    }

    public function onNewSignup($user, $request)
    {
        Slack::send("*New user signup:*\n{$user->name}\n{$user->email}\n{$request->getClientIp()}");
    }

    public function onNewConference($conference)
    {
        Slack::send("*New conference created:*\n{$conference->title}\n{$conference->link}");
    }
}
