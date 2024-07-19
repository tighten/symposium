<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    'slack_endpoint' => env('SLACK_ENDPOINT'),


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
