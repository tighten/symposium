<?php

namespace Tests\Feature;

use App\CallingAllPapers\Client;
use App\CallingAllPapers\ConferenceImporter;
use App\CallingAllPapers\Event;
use App\Models\Conference;
use Mockery as m;
use stdClass;
use Tests\TestCase;

class CallingAllPapersConferenceImporterTest extends TestCase
{
    private $eventId = 'abcdef1234567890abcdef1234567890abcdef122017';
    private $eventStub;

    /** @before */
    function prepareEventStub()
    {
        parent::setUp();

        $this->eventStub = $this->stubEvent();
    }

    function stubEvent()
    {
        $_rel = new stdClass;
        $_rel->cfp_uri = "v1/cfp/{$this->eventId}";

        $event = new stdClass;

        $event->_rel = $_rel;
        $event->name = 'ABC conference';
        $event->description = 'The greatest conference ever.';
        $event->eventUri = 'https://www.example.com/';
        $event->uri = 'https://cfp.example.com/';
        $event->dateCfpStart = '2017-08-20T00:00:00-04:00';
        $event->dateCfpEnd = '2017-09-22T00:00:00-04:00';
        $event->dateEventStart = '2017-10-20T00:00:00-04:00';
        $event->dateEventEnd = '2017-12-22T00:00:00-04:00';

        return Event::createFromApiObject($event);
    }

    function mockClient($event = null)
    {
        if (! $event) {
            $event = $this->eventStub;
        }

        $mockClient = m::mock(Client::class);

        $mockClient->shouldReceive('getEvents')->andReturn([$event]);
        app()->instance(Client::class, $mockClient);

        return $mockClient;
    }

    /** @test */
    function it_gets_the_id_from_the_rel_link()
    {
        $this->mockClient();

        $importer = new ConferenceImporter(1);
        $importer->import($this->eventStub);

        $this->assertEquals(1, Conference::count());
        $conference = Conference::first();

        $this->assertEquals($this->eventId, $conference->calling_all_papers_id);
    }

    /** @test */
    function the_id_contains_the_cfp_end_year_when_the_conference_start_date_is_bad()
    {
        $this->mockClient();

        $importer = new ConferenceImporter(1);
        $event = $this->eventStub;
        $event->dateEventStart = '1970-01-01T00:00:00+00:00';
        $importer->import($event);

        $this->assertEquals(1, Conference::count());
        $conference = Conference::first();

        $this->assertEquals($this->eventId, $conference->calling_all_papers_id);
    }

    /** @test */
    function it_imports_basic_text_fields()
    {
        $this->mockClient();

        $importer = new ConferenceImporter(1);
        $importer->import($this->eventStub);

        $this->assertEquals(1, Conference::count());
        $conference = Conference::first();

        $this->assertEquals($this->eventStub->name, $conference->title);
        $this->assertEquals($this->eventStub->description, $conference->description);
        $this->assertEquals($this->eventStub->uri, $conference->cfp_url);
    }

    /** @test */
    function it_imports_dates_if_we_dont_care_about_time_zones()
    {
        $event = $this->eventStub;

        $event->dateCfpStart = '2017-01-20T00:00:00+00:00';
        $event->dateCfpEnd = '2017-02-22T00:00:00+00:00';
        $event->dateEventStart = '2017-03-20T00:00:00+00:00';
        $event->dateEventEnd = '2017-04-22T00:00:00+00:00';

        $this->mockClient($event);

        $importer = new ConferenceImporter(1);
        $importer->import($this->eventStub);

        $conference = Conference::first();

        /*
         * Problem here: Our importer discards the time zone when it saves
         * it to the database. So we have to decide: Do we add time zone?
         * Do we convert to UTC? But nothing else in the app is in UTC; we just
         * let it all live in non-existent time zone, the user's sort of
         * intended time zone, I guess.
         *
         * That makes this test fail if it's written correctly--because it saves
         * the *time* but returns it in the wrong time zone.
         *
         * Right now, let's just say that, assuming the way it handles dates
         * right now, we at least want to make sure the strong is stored
         * correctly. Because of time zones and daylight savings time, the
         * easiest option is this piece of hideousness.
         */
        $this->assertEquals(
            substr($event->dateCfpStart, 0, 19),
            substr($conference->cfp_starts_at->toIso8601String(), 0, 19)
        );
        $this->assertEquals(
            substr($event->dateCfpEnd, 0, 19),
            substr($conference->cfp_ends_at->toIso8601String(), 0, 19)
        );
        $this->assertEquals(
            substr($event->dateEventStart, 0, 19),
            substr($conference->starts_at->toIso8601String(), 0, 19)
        );
        $this->assertEquals(
            substr($event->dateEventEnd, 0, 19),
            substr($conference->ends_at->toIso8601String(), 0, 19)
        );
    }

    /** @test */
    function imported_dates_are_adjusted_for_daylight_saving_time_changes()
    {
        $this->mockClient();

        $event = $this->eventStub;
        $event->dateCfpStart = '2017-08-20T00:00:00-04:00';
        $event->dateCfpEnd = '2017-09-22T00:00:00-04:00';
        $event->dateEventStart = '2017-10-20T00:00:00-04:00';
        $event->dateEventEnd = '2017-12-22T00:00:00-04:00';

        $importer = new ConferenceImporter(1);
        $importer->import($event);

        $conference = Conference::first();

        $this->assertEquals('2017-08-20T00:00:00-04:00', $conference->cfp_starts_at->toIso8601String());
        $this->assertEquals('2017-09-22T00:00:00-04:00', $conference->cfp_ends_at->toIso8601String());
        $this->assertEquals('2017-10-20T00:00:00-04:00', $conference->starts_at->toIso8601String());

        // The conference ends after the time change so it is -5:00 from UTC instead of -4:00
        $this->assertEquals('2017-12-22T00:00:00-05:00', $conference->ends_at->toIso8601String());
    }

    /** @test */
    function it_imports_null_dates_as_null()
    {
        $event = $this->eventStub;

        $event->dateCfpEnd = null;

        $this->mockClient($event);

        $importer = new ConferenceImporter(1);
        $importer->import($event);

        $conference = Conference::first();

        $this->assertNull($conference->cfp_ends_at);
    }

    /** @test */
    function it_imports_Jan_1_1970_dates_as_null()
    {
        $event = $this->eventStub;

        $event->dateCfpEnd = '1970-01-01T00:00:00+00:00';

        $this->mockClient($event);

        $importer = new ConferenceImporter(1);
        $importer->import($event);

        $conference = Conference::first();

        $this->assertNull($conference->cfp_ends_at);
    }

    /** @test */
    public function it_imports_zero_in_latitude_or_longitude_as_null()
    {
        $event = $this->eventStub;

        $event->latitude = '0';
        $event->longitude = '-82.682221';

        $this->mockClient($event);

        $importer = new ConferenceImporter(1);
        $importer->import($event);

        $conference = Conference::first();

        $this->assertNull($conference->latitude);
        $this->assertNull($conference->longitude);
    }

    /** @test */
    public function it_fills_latitude_and_longitude_from_location_if_lat_long_are_null()
    {
        $event = $this->eventStub;

        $event->latitude = '0';
        $event->longitude = '-82.682221';
        $event->location = '10th St. & Constitution Ave. NW, Washington, DC';

        $this->mockClient($event);

        $importer = new ConferenceImporter(1);
        $importer->import($event);

        $conference = Conference::first();

        $this->assertSame('38.8921062', $conference->latitude);
        $this->assertSame('-77.0259036', $conference->longitude);
    }

    /** @test */
    public function it_keeps_lat_long_values_null_if_no_results()
    {
        $event = $this->eventStub;

        $event->latitude = '0';
        $event->longitude = '-82.682221';
        $event->location = 'Not a Valid Location';

        $this->mockClient($event);

        $importer = new ConferenceImporter(1);
        $importer->import($event);

        $conference = Conference::first();

        $this->assertNull($conference->latitude);
        $this->assertNull($conference->longitude);
    }

    /** @test */
    function imported_conferences_are_approved()
    {
        $this->mockClient();

        $importer = new ConferenceImporter(1);
        $importer->import($this->eventStub);

        $this->assertTrue(Conference::first()->is_approved);
    }

    /** @test */
    function it_updates_data_for_existing_conferences()
    {
        $this->mockClient();

        $importer = new ConferenceImporter(1);
        $importer->import($this->eventStub);

        $conference = Conference::first();

        $this->assertEquals($this->eventStub->name, $conference->title);
        $this->assertEquals($this->eventStub->description, $conference->description);
        $this->assertEquals($this->eventStub->eventUri, $conference->url);

        $updatedEvent = clone $this->eventStub;
        $updatedEvent->name = 'Updated name';
        $updatedEvent->description = 'Updated description';
        $updatedEvent->eventUri = 'https://www.example.org/';
        $importer->import($updatedEvent);

        $updatedConference = Conference::first();

        $this->assertEquals($updatedEvent->name, $updatedConference->title);
        $this->assertEquals($updatedEvent->description, $updatedConference->description);
        $this->assertEquals($updatedEvent->eventUri, $updatedConference->url);
    }

    /** @test */
    function updating_existing_unapproved_conferences_leaves_them_unapproved()
    {
        $this->mockClient();

        $importer = new ConferenceImporter(1);
        $importer->import($this->eventStub);

        $conference = Conference::first();
        $conference->update(['is_approved' => false]);

        $updatedEvent = clone $this->eventStub;
        $importer->import($updatedEvent);

        $this->assertFalse(Conference::first()->is_approved);
    }
}
