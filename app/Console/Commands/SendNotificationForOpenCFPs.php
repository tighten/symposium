<?php

namespace App\Console\Commands;

use App\Conference;
use App\Notifications\CFPsAreOpen;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

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
        $conferences = $this->conferencesToShare()->get();

        if ($conferences->isEmpty()) {
            return;
        }

        $this->conferencesToShare()->update(['is_shared' => true]);

        Notification::send(User::wantsNotifications()->get(), new CFPsAreOpen($conferences));
    }

    protected function conferencesToShare()
    {
        return Conference::approved()->notShared()->openCFP();
    }
}
