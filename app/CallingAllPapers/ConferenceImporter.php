<?php

namespace App\CallingAllPapers;

use App\Models\Conference;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Validator;

class ConferenceImporter
{
    private $client;
    private $authorId;

    public function __construct(int $authorId = null, Client $client = null)
    {
        $this->client = $client ?: new Client;
        $this->authorId = $authorId ?: auth()->user()->id;
    }

    private static function carbonFromIso(?string $dateFromApi)
    {
        if (! $dateFromApi || $dateFromApi == '1970-01-01T00:00:00+00:00') {
            return null;
        }

        return Carbon::createFromFormat(DateTime::ISO8601, $dateFromApi);
    }

    public function import(Event $event)
    {
        // Ensure entities (i.e. tests) sharing this object are not affected by directly changing it
        $event = clone $event;

        $event->dateCfpStart = self::carbonFromIso($event->dateCfpStart);
        $event->dateCfpEnd = self::carbonFromIso($event->dateCfpEnd);
        $event->dateEventStart = self::carbonFromIso($event->dateEventStart);
        $event->dateEventEnd = self::carbonFromIso($event->dateEventEnd);

        $validator = Validator::make([
            'cfp_starts_at' => $event->dateCfpStart,
            'cfp_ends_at' => $event->dateCfpEnd,
            'starts_at' => $event->dateEventStart,
            'ends_at' => $event->dateEventEnd,
        ], [
            'cfp_starts_at' => ['nullable', 'date'],
            'cfp_ends_at' => [
                'nullable',
                'date',
                'after:cfp_starts_at',
                $event->dateEventStart ? 'before:starts_at' : '',
                'before:' . Carbon::parse($event->dateCfpStart)->addYears(2),
            ],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
                'before:' . Carbon::parse($event->dateEventStart)->addYears(2),
            ],
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 403);
        }

        $conference = Conference::firstOrNew(['calling_all_papers_id' => $event->id]);
        $this->updateConferenceFromCallingAllPapersEvent($conference, $event);

        $conference->save();
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
        $conference->starts_at = $event->dateEventStart;
        $conference->ends_at = $event->dateEventEnd;
        $conference->cfp_starts_at = $event->dateCfpStart;
        $conference->cfp_ends_at = $event->dateCfpEnd;
        $conference->author_id = $this->authorId;
    }
}
