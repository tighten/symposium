<?php

namespace App\Listeners;

use App\User;
use App\Notifications\CFPIsOpen;
use App\Events\ConferenceCreated;

class SendNotificationForOpenCFPs
{
    /**
     * Handle the event.
     *
     * @param  ConferenceCreated $event
     * @return void
     */
    public function handle(ConferenceCreated $event)
    {
        $conference = $event->conference;

        if ($conference->isCurrentlyAcceptingProposals()
            && $conference->isApproved()
            && !$conference->shared) {
            User::EnabledNotifications()->get()->each->notify(new CFPIsOpen($conference));
            $conference->update(['shared' => true]);
        }

    }
}
