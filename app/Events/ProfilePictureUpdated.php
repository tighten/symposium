<?php

namespace App\Events;

use App\Events\Event;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProfilePictureUpdated extends Event
{
    use SerializesModels;

    public $user;
    public $image;
    public $filename;

    /**
     * Create a new event instance.
     *
     * @param \App\User $user
     * @param           $image
     * @param           $filename
     */
    public function __construct(User $user, $image, $filename)
    {
        $this->user = $user;
        $this->image = $image;
        $this->filename = $filename;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
