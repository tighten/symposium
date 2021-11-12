<?php

namespace App\CallingAllPapers;

use App\Models\Conference;
use Carbon\Carbon;
use DateTime;

class ConferenceImporter
{
    private $client;
    private $authorId;

    public function __construct(int $authorId = null, Client $client = null)
    {
        $this->client = $client ?: new Client;
        $this->authorId = $authorId ?: auth()->user()->id;
    }

    private static function carbonFromIso($dateFromApi)
    {
        if (! $dateFromApi || $dateFromApi == '1970-01-01T00:00:00+00:00') {
            return null;
        }

        return Carbon::createFromFormat(DateTime::ISO8601, $dateFromApi);
    }

    public function import(Event $event)
    {
        $conference = Conference::firstOrNew(['calling_all_papers_id' => $event->id]);
        $this->updateConferenceFromCallingAllPapersEvent($conference, $event);
        if (
            config('services.google.maps.key')
            && ! $conference->latitude
            && ! $conference->longitude
            && $conference->location
        ) {
            $this->geocodeLatLongFromLocation($conference);
        }
        $conference->save();
    }

    private function updateConferenceFromCallingAllPapersEvent(Conference $conference, Event $event)
    {
        $conference->title = trim($event->name);
        $conference->description = trim($event->description);
        $conference->url = trim($event->eventUri);
        $conference->cfp_url = $event->uri;
        $conference->location = $event->location;
        $conference->latitude = $this->nullifyInvalidLatLong($event->latitude, $event->longitude);
        $conference->longitude = $this->nullifyInvalidLatLong($event->longitude, $event->latitude);
        $conference->starts_at = self::carbonFromIso($event->dateEventStart);
        $conference->ends_at = self::carbonFromIso($event->dateEventEnd);
        $conference->cfp_starts_at = self::carbonFromIso($event->dateCfpStart);
        $conference->cfp_ends_at = self::carbonFromIso($event->dateCfpEnd);
        $conference->author_id = $this->authorId;
    }

    private function nullifyInvalidLatLong($primary, $secondary)
    {
        return (float) $primary && (float) $secondary ? $primary : null;
    }

    private function geocodeLatLongFromLocation(Conference $conference): Conference
    {
        $response = app('geocoder')->geocode($conference->location)->get();

        if ($response->count()) {
            $conference->latitude = $response[0]->toArray()['latitude'];
            $conference->longitude = $response[0]->toArray()['longitude'];
        }

        return $conference;
    }
}
