<?php

namespace App\Listeners;

use App\Events\ProfilePictureUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UpdateProfilePicture
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProfilePictureUpdated  $event
     * @return void
     */
    public function handle(ProfilePictureUpdated $event)
    {
        //Make regular image
        $thumb = Image::make($event->image_path)
            ->fit(250, 250);

        //Make hires image
        $hires = Image::make($event->image_path)
            ->fit(1250, 1250, function ($constraint) {
                $constraint->upsize();
            });

        //Delete the previous profile picture
        // (although potentially not if people may have a second profile picture later down the line?)
        if ($event->user->profile_picture != null) {
            Storage::delete([
                'profile_pictures/' . $event->user->profile_picture,
                'profile_pictures/hires/' . $event->user->profile_picture
            ]);
        }

        //Store the new profile pictures
        Storage::put('profile_pictures/' . $event->filename, $thumb->stream());
        Storage::put('profile_pictures/hires/' . $event->filename, $hires->stream());

        //Save the updated filename to the user
        $event->user->updateProfilePicture($event->filename);

    }
}
