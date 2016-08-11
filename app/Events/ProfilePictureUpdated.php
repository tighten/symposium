<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProfilePictureUpdated extends Event
{
    use SerializesModels;

    public $image;
    public $filename;

    /**
     * Create a new event instance.
     *
     * @param $image
     * @param $filename
     */
    public function __construct($image, $filename)
    {
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
