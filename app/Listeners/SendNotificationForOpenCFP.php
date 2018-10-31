<?php

namespace App\Listeners;

use App\User;
use App\Notifications\CFPIsOpen;
use App\Events\NewConferenceCreated;

class SendNotificationForOpenCFP
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  NewConferenceCreated $event
     * @return void
     */
    public function handle(NewConferenceCreated $event)
    {
        $conference = $event->conference;

        if ($conference->isCurrentlyAcceptingProposals()) {
            User::all()->each->notify(new CFPIsOpen($conference));
        }

    }
}
