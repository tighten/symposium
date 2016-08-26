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
    public $image_path;
    public $filename;

    /**
     * ProfilePictureUpdated constructor.
     *
     * @param User $user
     * @param      $image_path
     * @param      $filename
     */
    public function __construct(User $user, $image_path, $filename)
    {
        $this->user = $user;
        $this->image_path = $image_path;
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
