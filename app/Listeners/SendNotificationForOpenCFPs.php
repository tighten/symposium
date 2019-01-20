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
            && $conference->is_approved
            && !$conference->is_shared) {
            $conference->update(['is_shared' => true]);

            User::wantsNotifications()->get()->each->notify(new CFPIsOpen($conference));
        }
    }
}
