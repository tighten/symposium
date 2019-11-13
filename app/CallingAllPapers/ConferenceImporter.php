<?php

namespace App\CallingAllPapers;

use App\Conference;
use App\Events\ConferenceCreated;
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

    public function import(Event $event)
    {
        $conference = Conference::firstOrNew(['calling_all_papers_id' => $event->id]);
        $this->updateConferenceFromCallingAllPapersEvent($conference, $event);
        $conference->save();
        event(new ConferenceCreated($conference));
    }

    private function updateConferenceFromCallingAllPapersEvent(Conference $conference, Event $event)
    {
        $conference->title = trim($event->name);
        $conference->description = trim($event->description);
        $conference->url = trim($event->eventUri);
        $conference->cfp_url = $event->uri;
        $conference->location = $event->location;
        $conference->latitude = $event->latitude;
        $conference->longitude = $event->longitude;
        $conference->starts_at = self::carbonFromIso($event->dateEventStart);
        $conference->ends_at = self::carbonFromIso($event->dateEventEnd);
        $conference->cfp_starts_at = self::carbonFromIso($event->dateCfpStart);
        $conference->cfp_ends_at = self::carbonFromIso($event->dateCfpEnd);
        $conference->author_id = $this->authorId;
        $conference->is_approved = true;
    }

    private static function carbonFromIso($dateFromApi)
    {
        if (! $dateFromApi || $dateFromApi == '1970-01-01T00:00:00+00:00') {
            return null;
        }

        return Carbon::createFromFormat(DateTime::ISO8601, $dateFromApi);
    }
}
