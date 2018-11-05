<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        //
    }
}
