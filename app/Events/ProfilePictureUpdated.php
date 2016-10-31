<?php

namespace App\Events;

use App\User;
use Illuminate\Queue\SerializesModels;

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
