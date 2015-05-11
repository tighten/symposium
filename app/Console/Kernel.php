<?php namespace Symposium\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'Symposium\Console\Commands\syncJoindInEvents',
        'Symposium\Console\Commands\TweetImportantCFPDates'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('joindin:sync')
            ->hourly();

        $schedule->command('tweet:cfpDates')
             ->dailyAt('08:00')
             ->environments('production');
    }
}
