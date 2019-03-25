<?php

namespace App\Providers;

use App\Events\ConferenceCreated;
use App\Handlers\Events\SlackSubscriber;
use App\Listeners\SendNotificationForOpenCFPs;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ConferenceCreated::class => [
            SendNotificationForOpenCFPs::class,
        ],
    ];

    protected $subscribe = [
        SlackSubscriber::class,
    ];
}
