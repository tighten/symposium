<?php

namespace App\Providers;

use App\Events\ProfilePictureUpdated;
use App\Listeners\UpdateProfilePicture;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
    ];

    public function boot()
    {
    }
}
