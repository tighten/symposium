<?php

namespace App\Handlers\Events;

use App\Models\TightenSlack;
use App\Notifications\NewConference;
use App\Notifications\NewUser;

class SlackSubscriber
{
    protected $slack;

    public function __construct(TightenSlack $slack)
    {
        $this->slack = $slack;
    }

    public function subscribe($events)
    {
        $events->listen('new-signup', [$this, 'onNewSignup']); // @codeCoverageIgnore
        $events->listen('new-conference', [$this, 'onNewConference']);
    }

    /**
     * @codeCoverageIgnore
     */
    public function onNewSignup($user, $request)
    {
        $this->slack->notify(new NewUser($user, $request->getClientIp()));
    }

    public function onNewConference($conference)
    {
        $this->slack->notify(new NewConference($conference));
    }
}
