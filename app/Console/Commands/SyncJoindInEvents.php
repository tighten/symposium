<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use JoindIn\Client as JoindInClient;
use App\JoindIn\ConferenceImporter;

class SyncJoindInEvents extends Command
{
    protected $name = 'joindin:sync';

    protected $description = 'Sync down Joind.in events.';

    protected $client;
    private $importer;

    public function __construct()
    {
        parent::__construct();

        // @todo handle this better
        $adminUserId = 1;

        $this->client = JoindInClient::factory();
        $this->importer = new ConferenceImporter($adminUserId);
    }

    public function handle()
    {
        $this->info('Syncing events...');

        foreach ($this->client->getEvents() as $event) {
            $this->info('Creating/updating event ' . $event['name']);
            $this->importer->import($event['id']);
        }

        $this->info('Events synced.');
    }
}
