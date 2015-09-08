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

        $joindInIds = Conference::all()->lists('joindin_id')->toArray();

        foreach ($this->client->getEvents() as $conference) {
            $this->importer->import($conference['id']);

            if (in_array($conference['id'], $joindInIds)) {
                $this->info('Updating event ' . $conference['name']);
            } else {
                $this->info('Downloading event ' . $conference['name']);
            }
        }

        $this->info('Events synced.');
    }
}
