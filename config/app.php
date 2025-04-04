<?php

use Illuminate\Support\Facades\Facade;

return [

    'timezone' => 'America/Detroit',

    'slack_endpoint' => env('SLACK_ENDPOINT'),

    'aliases' => Facade::defaultAliases()->merge([
        'Gravatar' => Creativeorange\Gravatar\Facades\Gravatar::class,
        'Image' => Intervention\Image\Facades\Image::class,
        'Input' => Illuminate\Support\Facades\Input::class,
        'Inspiring' => Illuminate\Foundation\Inspiring::class,
        'Paginator' => Illuminate\Support\Facades\Paginator::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,
    ])->toArray(),

];
