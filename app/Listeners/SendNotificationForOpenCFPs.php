<?php

namespace App\Listeners;

use App\Events\ConferenceCreated;
use App\Notifications\CFPIsOpen;
use App\User;
use Illuminate\Support\Facades\Notification;

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

            Notification::send(User::wantsNotifications()->get(), new CFPIsOpen($conference));
        }
    }
}
