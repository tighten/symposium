<?php

namespace App\Providers;

use App\Events\ConferenceCreated;
use App\Listeners\SendNotificationForOpenCFPs;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ConferenceCreated::class => [
            SendNotificationForOpenCFPs::class,
        ],

    ];
}
