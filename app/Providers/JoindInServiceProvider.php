<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JoindIn\Client;

class JoindInServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Client::class, function ($app) {
            return Client::factory();
        });
    }
}
