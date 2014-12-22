<?php

use Illuminate\Console\Command;
use JoindIn\Client;
use SaveMyProposals\JoindIn\ConferenceImporter;

class syncJoindInEvents extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'joindin:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync down Joind.in events.';

    /**
     * @var Client
     */
    protected $client;
    /**
     * @var ConferenceImporter
     */
    private $importer;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
        // @todo handle this better
        $adminUserId = 1;

        $this->client = Client::factory();
        $this->importer = new ConferenceImporter($adminUserId);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info('Syncing events...');

        foreach ($this->listUnsyncedEvents() as $event) {
            $this->info('Downloading event ' . $event['name']);
            $this->importer->import($event['id']);
        }

        $this->info('Events synced.');
    }

    /**
     * Get a list of every event in Joind.in that doesn't exist in our system
     *
     * @return array
     */
    protected function listUnsyncedEvents()
    {
        $return = [];

        $conferences = $this->client->getEvents();

        $alreadyConferences = Conference::all();
        $joindinIds = $alreadyConferences->map(function($conference) {
            return (int)$conference->joindin_id;
        });
        $joindinIdsArray = $joindinIds->toArray();

        // @todo this should be a lot simpler if we can get the Collection working
        foreach ($conferences as $conference) {
            if (! in_array($conference['id'], $joindinIdsArray)) {
                $return[] = $conference;
            }
        }

        return $return;
    }
}
