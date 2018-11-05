<?php

namespace App\Listeners;

use App\User;
use App\Notifications\CFPIsOpen;
use App\Events\ConferenceCreated;

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
     * @param  ConferenceCreated $event
     * @return void
     */
    public function handle(ConferenceCreated $event)
    {
        $conference = $event->conference;

        if ($conference->isCurrentlyAcceptingProposals()) {
            User::all()->each->notify(new CFPIsOpen($conference));
        }

    }
}
