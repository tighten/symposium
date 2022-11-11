<?php

namespace App\Console\Commands;

use App\CallingAllPapers\Client;
use App\CallingAllPapers\ConferenceImporter;
use App\Models\TightenSlack;
use App\Notifications\ConferenceImporterError;
use App\Notifications\ConferenceImporterFinished;
use App\Notifications\ConferenceImporterStarted;
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

    public function handle()
    {
        $this->info('Syncing events...');
        $this->slack->notify(new ConferenceImporterStarted());

        try {
            $events = $this->client->getEvents();
        } catch (Exception $exception) {
            $this->error("Unable to sync Calling All Papers events. Message: {$exception->getMessage()}");
            $this->slack->notify(new ConferenceImporterError($exception));

            return;
        }

        foreach ($events as $event) {
            $this->info("Creating/updating event {$event->name}");
            $this->importer->import($event);
        }

        $this->info('Events synced.');
        $this->slack->notify(new ConferenceImporterFinished());
    }
}
