<?php namespace SaveMyProposals\JoindIn;

use Carbon\Carbon;
use Conference;
use Guzzle\Http\Exception\ClientErrorResponseException;
use JoindIn\Client;

class ConferenceImporter
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = Client::factory();
    }

    public function import($eventId)
    {
        try {
            $event = $this->client->getEvent((int)$eventId);
        } catch (ClientErrorResponseException $e) {
            \App::abort('No conference available for #' . $eventId);
        }

        $conference = $this->mapEventToConference($eventId, $event[0]);
        $conference->save();
    }

    private function mapEventToConference($eventId, array $event)
    {
        $conference = new Conference;
        $conference->title = $event['name'];
        $conference->description = $event['description'];
        $conference->joindin_id = $eventId;
        $conference->url = $event['website_uri'];
        $conference->starts_at = $this->carbonFromIso($event['start_date']);
        $conference->ends_at = $this->carbonFromIso($event['end_date']);
        $conference->cfp_starts_at = $this->carbonFromIso($event['cfp_start_date']);
        $conference->cfp_ends_at = $this->carbonFromIso($event['cfp_end_date']);
        $conference->author_id = \Auth::user()->id;
//        $conference->cfp_url = $event['cfp_url'];

        return $conference;
    }

    private function carbonFromIso($string)
    {
        return Carbon::createFromFormat(\DateTime::ISO8601, $string);
    }
}
