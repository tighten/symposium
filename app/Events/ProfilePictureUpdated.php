<?php

namespace App\Events;

use App\Events\Event;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProfilePictureUpdated extends Event
{
    use SerializesModels;

    public $previous_profile_image;
    public $image;
    public $filename;

    /**
     * Create a new event instance.
     *
     * @param $previous_profile_image
     * @param $image
     * @param $filename
     */
    public function __construct($previous_profile_image, $image, $filename)
    {
        $this->previous_profile_image = $previous_profile_image;
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
