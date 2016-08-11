<?php

namespace App\Listeners;

use App\Events\ProfilePictureUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Intervention\Image\Facades\Image;

class UpdateProfilePicture implements ShouldQueue
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
        Image::make($event->image)
            ->fit(250,250)
            ->save(public_path('img/profile_images/' . $event->filename));

        //Make hires image
        Image::make($event->image)
            ->fit(1250,1250, function ($constraint){
                $constraint->upsize();
            })
            ->save(public_path('img/profile_images/hires/' . $event->filename));
    }
}
