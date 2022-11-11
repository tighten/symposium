<?php

namespace Tests\Feature;

use App\Notifications\ConferenceImporterError;
use App\Notifications\ConferenceImporterFinished;
use App\Notifications\ConferenceImporterRejection;
use App\Notifications\ConferenceImporterStarted;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Tests\MocksCallingAllPapers;
use Tests\TestCase;

class SyncCallingAllPapersEventsTest extends TestCase
{
    use RefreshDatabase;
    use MocksCallingAllPapers;

    protected $eventStub;

    /** @test */
    function notifying_slack_when_command_starts_and_ends()
    {
        Notification::fake();
        $this->stubEvent();
        $this->mockClient();

        Artisan::call('callingallpapers:sync');

        Notification::assertSentToTightenSlack(ConferenceImporterStarted::class);
        Notification::assertSentToTightenSlack(ConferenceImporterFinished::class);
    }

    /** @test */
    function notifying_slack_when_command_errors()
    {
        Notification::fake();
        $this->stubEvent();
        $this->mockClientWithError();

        Artisan::call('callingallpapers:sync');

        Notification::assertSentToTightenSlack(ConferenceImporterStarted::class);
        Notification::assertSentToTightenSlack(ConferenceImporterError::class);
        Notification::assertNotSentToTightenSlack(ConferenceImporterFinished::class);
    }

    /** @test */
    function notifying_slack_when_conference_is_rejected()
    {
        Notification::fake();
        $this->stubEvent();
        $this->eventStub->dateEventStart = '2017-10-01T00:00:00-04:00';
        $this->eventStub->dateEventEnd = '2020-10-01T00:00:00-04:00';
        $this->mockClient();

        Artisan::call('callingallpapers:sync');

        Notification::assertSentToTightenSlack(ConferenceImporterStarted::class);
        Notification::assertSentToTightenSlack(ConferenceImporterRejection::class);
        Notification::assertSentToTightenSlack(ConferenceImporterFinished::class);
    }
}
