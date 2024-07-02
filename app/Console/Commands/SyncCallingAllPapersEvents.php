<?php

namespace App\Console\Commands;

use App\CallingAllPapers\Client;
use App\CallingAllPapers\ConferenceImporter;
use App\Models\TightenSlack;
use App\Notifications\ConferenceImporterError;
use Exception;
use Illuminate\Console\Command;

class SyncCallingAllPapersEvents extends Command
{
    protected $name = 'callingallpapers:sync';

    protected $description = 'Pull down CallingAllPapers events';

    protected $client;

    protected $slack;

    private $importer;

    public function __construct(Client $client, TightenSlack $slack)
    {
        parent::__construct();

        $this->client = $client;
        $this->slack = $slack;
        $this->importer = new ConferenceImporter($adminUserId = 1);
    }

    public function handle(): void
    {
        $this->info('Syncing events...');

        try {
            $events = $this->client->getEvents();
        } catch (Exception $exception) {
            $this->error("Unable to sync Calling All Papers events. Message: {$exception->getMessage()}");
            $this->slack->notify(new ConferenceImporterError($exception));

            return;
        }

        foreach ($events as $event) {
            $this->info("Creating/updating event {$event->name}");
            $conference = $this->importer->import($event);
        }

        $this->info('Events synced.');
        cache(['conference_importer_last_ran_at' => now()->toDateTimeString()]);
    }
}
