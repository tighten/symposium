<?php

namespace App\Listeners;

use App\Events\ProfilePictureUpdated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UpdateProfilePicture
{
    const THUMB_SIZE = 250;
    const HIRES_SIZE = 1250;

    public function handle(ProfilePictureUpdated $event)
    {
        // Make regular image
        $thumb = Image::make($event->image->getRealPath())
            ->fit(self::THUMB_SIZE, self::THUMB_SIZE);

        // Make hires image
        $hires = Image::make($event->image->getRealPath())
            ->fit(self::HIRES_SIZE, self::HIRES_SIZE, function ($constraint) {
                $constraint->upsize();
            });

        // Delete the previous profile pictures
        if ($event->user->profile_picture != null) {
            Storage::delete([
                User::PROFILE_PICTURE_THUMB_PATH . $event->user->profile_picture,
                User::PROFILE_PICTURE_HIRES_PATH . $event->user->profile_picture
            ]);
        }

        // Store the new profile pictures
        Storage::put(User::PROFILE_PICTURE_THUMB_PATH . $event->image->hashName(), $thumb->stream());
        Storage::put(User::PROFILE_PICTURE_HIRES_PATH . $event->image->hashName(), $hires->stream());

        // Save the updated filename to the user
        $event->user->updateProfilePicture($event->image->hashName());
    }
}
