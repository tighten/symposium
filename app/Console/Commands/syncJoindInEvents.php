<?php namespace Symposium\Console\Commands;

use Conference;
use Illuminate\Console\Command;
use JoindIn\Client;
use Symposium\JoindIn\ConferenceImporter;

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

        $joindInIds = Conference::all()->lists('joindin_id')->toArray();

        foreach ($this->client->getEvents() as $conference) {
            if (in_array($conference['id'], $joindInIds)) {
                $this->updateConference($conference);
            } else {
                $this->addConference($conference);
            }
        }

        $this->info('Events synced.');
    }

    private function updateConference($conference)
    {
        $this->info('Updating event ' . $conference['name']);
        $this->importer->update($conference['id']);
    }

    private function addConference($conference)
    {
        $this->info('Downloading event ' . $conference['name']);
        $this->importer->import($conference['id']);
    }
}
