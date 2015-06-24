<?php namespace Symposium\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use LucaDegasperi\OAuth2Server\Authorizer;
use Symposium\OAuthGuard\OAuthGuard;

class OAuthGuardServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['OAuthGuard'] = $this->app->share(function ($app) {
            return new OAuthGuard($app->make(Authorizer::class));
        });

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('OAuthGuard', 'Symposium\OAuthGuard\Facades\OAuthGuard');
        });
    }
}
