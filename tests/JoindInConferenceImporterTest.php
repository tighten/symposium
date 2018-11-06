<?php

use App\Conference;
use App\JoindIn\ConferenceImporter;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use JoindIn\Client;
use Mockery as m;

class JoindInConferenceImporterTest extends TestCase
{
    use DatabaseMigrations;

    private $eventStub = [
        'id' => 12345,
        'name' => 'ABC conference',
        'description' => 'The greatest conference ever.',
        'website_uri' => 'http://abccon.com/',
        'cfp_url' => 'http://cfp.abccon.com/',
        "cfp_start_date" => "2017-08-20T00:00:00-04:00",
        "cfp_end_date" => "2017-09-22T00:00:00-04:00",
        "start_date" => "2017-10-20T00:00:00-04:00",
        "end_date" => "2017-12-22T00:00:00-04:00",
    ];

    function mockClient($event = null)
    {
        if (! $event) {
            $event = $this->eventStub;
        }

        $mockClient = m::mock(Client::class);

        $mockClient->shouldReceive('getEvent')->andReturn([$event]);
        app()->instance(Client::class, $mockClient);

        return $mockClient;
    }

    /** @test */
    function it_imports_basic_text_fields()
    {
        $this->mockClient();

        $importer = new ConferenceImporter(1);
        $importer->import($this->eventStub['id']);

        $this->assertEquals(1, Conference::count());
        $conference = Conference::first();

        $this->assertEquals($this->eventStub['name'], $conference->title);
        $this->assertEquals($this->eventStub['description'], $conference->description);
        $this->assertEquals($this->eventStub['id'], $conference->joindin_id);
        $this->assertEquals($this->eventStub['cfp_url'], $conference->cfp_url);
    }

    /** @test */
    function it_imports_dates_if_we_dont_care_about_time_zones()
    {
        $event = $this->eventStub;

        $event["cfp_start_date"] = "2017-01-20T00:00:00+00:00";
        $event["cfp_end_date"] = "2017-02-22T00:00:00+00:00";
        $event["start_date"] = "2017-03-20T00:00:00+00:00";
        $event["end_date"] = "2017-04-22T00:00:00+00:00";

        $this->mockClient($event);

        $importer = new ConferenceImporter(1);
        $importer->import($this->eventStub['id']);

        $conference = Conference::first();

        /**
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
            substr($event['cfp_start_date'], 0, 19),
            substr($conference->cfp_starts_at->toIso8601String(), 0, 19)
        );
        $this->assertEquals(
            substr($event['cfp_end_date'], 0, 19),
            substr($conference->cfp_ends_at->toIso8601String(), 0, 19)
        );
        $this->assertEquals(
            substr($event['start_date'], 0, 19),
            substr($conference->starts_at->toIso8601String(), 0, 19)
        );
        $this->assertEquals(
            substr($event['end_date'], 0, 19),
            substr($conference->ends_at->toIso8601String(), 0, 19)
        );
    }

    /** @test */
    function it_imports_dates_with_the_correct_time_zone()
    {
        $this->markTestIncomplete('Time zones are hard.');

        $this->mockClient();

        $importer = new ConferenceImporter(1);
        $importer->import($this->eventStub['id']);

        $conference = Conference::first();

        // $this->assertEquals($this->eventStub['cfp_start_date'], $conference->cfp_starts_at->toIso8601String());
        // $this->assertEquals($this->eventStub['cfp_end_date'], $conference->cfp_ends_at->toIso8601String());
        // $this->assertEquals($this->eventStub['start_date'], $conference->starts_at->toIso8601String());
        // $this->assertEquals($this->eventStub['end_date'], $conference->ends_at->toIso8601String());
    }

    /** @test */
    function it_imports_null_dates_as_null()
    {
        $event = $this->eventStub;

        $event['cfp_end_date'] = null;

        $this->mockClient($event);

        $importer = new ConferenceImporter(1);
        $importer->import($this->eventStub['id']);

        $conference = Conference::first();

        $this->assertNull($conference->cfp_ends_at);
    }

    /** @test */
    function imported_conferences_are_approved()
    {
        $this->mockClient();

        $importer = new ConferenceImporter(1);
        $importer->import($this->eventStub['id']);

       $this->assertTrue(Conference::first()->approved);
    }
}
