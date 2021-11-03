<?php

namespace App\Handlers\Events;

use App\Models\TightenSlack;
use App\Notifications\NewConference;
use App\Notifications\NewUser;
use Illuminate\Support\Facades\App;

class SlackSubscriber
{
    protected $slack;

    public function __construct(TightenSlack $slack)
    {
        $this->slack = $slack;
    }

    public function subscribe($events)
    {
        if (empty(config('app.slack_endpoint')) || App::environment('testing')) {
            return;
        }

        $events->listen('new-signup', [$this, 'onNewSignup']);
        $events->listen('new-conference', [$this, 'onNewConference']);
    }

    public function onNewSignup($user, $request)
    {
        $this->slack->notify(new NewUser($user, $request->getClientIp()));
    }

    public function onNewConference($conference)
    {
        $this->slack->notify(new NewConference($conference));
    }
}
