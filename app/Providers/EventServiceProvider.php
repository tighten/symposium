<?php

namespace App\Providers;

use App\Handlers\Events\SlackSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [];

    protected $subscribe = [
        SlackSubscriber::class,
    ];
}
