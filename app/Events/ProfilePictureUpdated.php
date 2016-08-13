<?php

namespace App\Events;

use App\Events\Event;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProfilePictureUpdated extends Event
{
    use SerializesModels;

    public $user;
    public $image;
    public $image_ext;

    /**
     * ProfilePictureUpdated constructor.
     *
     * @param User $user
     * @param      $image
     * @param      $image_ext
     */
    public function __construct(User $user, $image, $image_ext)
    {
        $this->user = $user;
        $this->image = $image;
        $this->image_ext = $image_ext;
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
