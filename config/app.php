<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    'slack_endpoint' => env('SLACK_ENDPOINT'),

    'providers' => ServiceProvider::defaultProviders()->merge([
        Laravel\Scout\ScoutServiceProvider::class,
        Laravel\Passport\PassportServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

        /*
         * Third Party Service Providers...
         */
        Bugsnag\BugsnagLaravel\BugsnagServiceProvider::class,
        Collective\Html\HtmlServiceProvider::class,
        Creativeorange\Gravatar\GravatarServiceProvider::class,
        Atymic\Twitter\ServiceProvider\LaravelServiceProvider::class,
        PragmaRX\Firewall\Vendor\Laravel\ServiceProvider::class,
        App\Providers\CaptchaServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        Laravel\Socialite\SocialiteServiceProvider::class,
    ])->toArray(),

    'aliases' => Facade::defaultAliases()->merge([
        'Bugsnag' => Bugsnag\BugsnagLaravel\Facades\Bugsnag::class,
        'Firewall' => PragmaRX\Firewall\Vendor\Laravel\Facade::class,
        'Gravatar' => Creativeorange\Gravatar\Facades\Gravatar::class,
        'HTML' => Collective\Html\HtmlFacade::class,
        'Image' => Intervention\Image\Facades\Image::class,
        'Input' => Illuminate\Support\Facades\Input::class,
        'Inspiring' => Illuminate\Foundation\Inspiring::class,
        'Paginator' => Illuminate\Support\Facades\Paginator::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,
        'Twitter' => Atymic\Twitter\Facade\Twitter::class,
    ])->toArray(),

];
