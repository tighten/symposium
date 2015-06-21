<?php namespace Symposium\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use LucaDegasperi\OAuth2Server\Authorizer;
use Symposium\oAuthGuard\oAuthGuard;

class oAuthGuardServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['oAuthGuard'] = $this->app->share(function ($app) {
            return new oAuthGuard($app->make(Authorizer::class));
        });

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('oAuthGuard', 'Symposium\oAuthGuard\Facades\oAuthGuard');
        });
    }
}
