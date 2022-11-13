<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\SyncCallingAllPapersEvents::class,
        Commands\TweetImportantCFPDates::class,
        Commands\SendNotificationForOpenCFPs::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('callingallpapers:sync')
        //     ->hourly();

        // $schedule->command('tweet:cfpDates')
        //      ->dailyAt('08:00')
        //      ->environments('production');

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
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
