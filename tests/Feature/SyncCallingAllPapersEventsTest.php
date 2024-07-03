<?php

namespace Tests\Feature;

use App\Notifications\ConferenceImporterError;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\MocksCallingAllPapers;
use Tests\TestCase;

class SyncCallingAllPapersEventsTest extends TestCase
{
    use MocksCallingAllPapers;
    use RefreshDatabase;

    protected $eventStub;

    #[Test]
    public function caching_timestamp_when_command_ends(): void
    {
        Notification::fake();
        Carbon::setTestNow('2022-05-04 11:11:11');
        $this->stubEvent();
        $this->mockClient();

        Artisan::call('callingallpapers:sync');

        $this->assertEquals(
            '2022-05-04 11:11:11',
            cache('conference_importer_last_ran_at'),
        );
    }

    #[Test]
    public function notifying_slack_when_command_errors(): void
    {
        Notification::fake();
        $this->stubEvent();
        $this->mockClientWithError();

        Artisan::call('callingallpapers:sync');

        Notification::assertSentToTightenSlack(ConferenceImporterError::class);
    }
}
