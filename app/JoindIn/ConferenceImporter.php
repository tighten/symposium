<?php namespace App\JoindIn;

use Carbon\Carbon;
use App\Models\Conference;
use DateTime;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use JoindIn\Client;

class ConferenceImporter
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var integer
     */
    private $authorId;

    public function __construct($authorId = null)
    {
        $this->client = Client::factory();

        $this->authorId = $authorId ?: Auth::user()->id;
    }

    public function import($eventId)
    {
        $event = $this->getJoindInEvent($eventId);
        $conference = Conference::firstOrNew(['joindin_id' => $eventId]);
        $this->updateConferenceFromJoindInEvent($conference, $event);
        $conference->save();
    }

    private function getJoindInEvent($eventId)
    {
        try {
            $event = $this->client->getEvent((int)$eventId);
        } catch (ClientErrorResponseException $e) {
            App::abort('No conference available for #' . $eventId);
        }

        $event = $event[0];
        $event['id'] = $eventId;
        return $event;
    }

    private function updateConferenceFromJoindInEvent($conference, $event)
    {
        $conference->title = trim($event['name']);
        $conference->description = trim($event['description']);
        $conference->joindin_id = $event['id'];
        $conference->url = trim($event['website_uri']);
        $conference->cfp_url = $event['cfp_url'];
        $conference->starts_at = $this->carbonFromIso($event['start_date']);
        $conference->ends_at = $this->carbonFromIso($event['end_date']);
        $conference->cfp_starts_at = $this->carbonFromIso($event['cfp_start_date']);
        $conference->cfp_ends_at = $this->carbonFromIso($event['cfp_end_date']);
        $conference->author_id = $this->authorId;
    }

    private function carbonFromIso($dateFromApi)
    {
        if ($dateFromApi == null) {
            return Carbon::create(null);
        }

        return Carbon::createFromFormat(DateTime::ISO8601, $dateFromApi);
    }
}
