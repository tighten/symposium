<?php

namespace App\Console\Commands;

use App\User;
use App\Conference;
use Illuminate\Console\Command;
use App\Notifications\CFPIsOpen;

class SendNotificationForOpenCFPs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'symposium:notifyCfps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send out notification for open CFPs';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Conference::Approved()->NotShared()->each(function($conference) {
            User::EnabledNotifications()->get()->each->notify(new CFPIsOpen($conference));
            $conference->update(['shared' => true]);
        });

    }
}
