<?php

namespace App\JoindIn;

use App\Conference;
use App\Events\ConferenceCreated;
use Carbon\Carbon;
use DateTime;
use Guzzle\Http\Exception\ClientErrorResponseException;
use JoindIn\Client as JoindInClient;

class ConferenceImporter
{
    private $client;
    private $authorId;

    public function __construct($authorId = null)
    {
        $this->client = app(JoindInClient::class);
        $this->authorId = $authorId ?: auth()->user()->id;
    }

    public function import($eventId)
    {
        $event = $this->getJoindInEvent($eventId);
        $conference = Conference::firstOrNew(['joindin_id' => $eventId]);
        $this->updateConferenceFromJoindInEvent($conference, $event);
        $conference->save();
        event(new ConferenceCreated($conference));
    }

    private function getJoindInEvent($eventId)
    {
        try {
            $event = $this->client->getEvent((int) $eventId);
        } catch (ClientErrorResponseException $e) {
            abort('No conference available for #' . $eventId);
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
        $conference->approved = true;
    }

    private function carbonFromIso($dateFromApi)
    {
        if (! $dateFromApi) {
            return null;
        }

        return Carbon::createFromFormat(DateTime::ISO8601, $dateFromApi);
    }
}
