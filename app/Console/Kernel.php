<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SyncJoindInEvents::class,
        \App\Console\Commands\TweetImportantCFPDates::class,
        \App\Console\Commands\SendNotificationForOpenCFPs::class
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('joindin:sync')
            ->hourly();

        $schedule->command('tweet:cfpDates')
             ->dailyAt('08:00')
             ->environments('production');

        $schedule->command('symposium:notifyCfps')
            ->dailyAt('08:00')
            ->environments('production');
    }
    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
