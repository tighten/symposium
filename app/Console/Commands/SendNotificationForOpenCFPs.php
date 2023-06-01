<?php

namespace App\Console\Commands;

use App\Models\Conference;
use App\Models\User;
use App\Notifications\CFPsAreOpen;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendNotificationForOpenCFPs extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'symposium:notifyCfps';

    /**
     * The console command description.
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
        return Conference::approved()->notShared()->whereCfpIsOpen();
    }
}
