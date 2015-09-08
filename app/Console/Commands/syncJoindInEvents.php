<?php namespace Symposium\Console\Commands;

use Conference;
use Illuminate\Console\Command;
use JoindIn\Client;
use Symposium\JoindIn\ConferenceImporter;

class syncJoindInEvents extends Command
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

        $this->client = Client::factory();
        $this->importer = new ConferenceImporter($adminUserId);
    }

    public function fire()
    {
        $this->info('Syncing events...');

        foreach ($this->client->getEvents() as $conference) {
            $this->info('Creating/updating event ' . $conference['name']);
            $this->importer->import($conference['id']);
        }

        $this->info('Events synced.');
    }
}
