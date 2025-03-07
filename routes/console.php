<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('callingallpapers:sync')
    ->hourly();

Schedule::command('symposium:notifyCfps')
    ->dailyAt('08:00')
    ->environments('production');

Schedule::command('verify-conference-importer-heartbeat')
    ->dailyAt('10:00')
    ->environments('production');
