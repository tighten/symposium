<?php

namespace App\Console\Commands;

use App\Models\TightenSlack;
use App\Notifications\ConferenceImporterInactive;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class VerifyConferenceImporterHeartbeat extends Command
{
    protected $signature = 'verify-conference-importer-heartbeat';

    protected $description = 'Notify Slack if the conference importer appears inactive.';

    public function handle()
    {
        if ($this->importerAppearsInactive()) {
            (new TightenSlack())->notify(new ConferenceImporterInactive());
        }

        return Command::SUCCESS;
    }

    private function importerAppearsInactive()
    {
        return Carbon::parse(cache('conference_importer_last_ran_at'))
            ->isBefore(now()->subHours(24));
    }
}
