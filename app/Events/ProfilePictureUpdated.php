<?php

namespace App\Events;

use App\Events\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProfilePictureUpdated extends Event
{
    use SerializesModels;

    public $user;
    public $image;

    public function __construct(User $user, $image)
    {
        $this->user = $user;
        $this->image = $image;
    }
}
