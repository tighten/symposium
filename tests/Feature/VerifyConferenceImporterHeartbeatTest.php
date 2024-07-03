<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use App\Notifications\ConferenceImporterInactive;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VerifyConferenceImporterHeartbeatTest extends TestCase
{
    #[Test]
    public function slack_is_notified_when_the_importer_has_not_run_in_24_hours(): void
    {
        Notification::fake();
        cache(['conference_importer_last_ran_at' => now()->subHours(25)->toDateTimeString()]);

        $this->artisan('verify-conference-importer-heartbeat');

        Notification::assertSentToTightenSlack(ConferenceImporterInactive::class);
    }

    #[Test]
    public function slack_is_not_notified_when_the_importer_has_run_within_24_hours(): void
    {
        Notification::fake();
        cache(['conference_importer_last_ran_at' => now()->subHours(23)->toDateTimeString()]);

        $this->artisan('verify-conference-importer-heartbeat');

        Notification::assertNotSentToTightenSlack(ConferenceImporterInactive::class);
    }
}
