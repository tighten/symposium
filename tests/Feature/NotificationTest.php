<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\User;
use App\Notifications\CFPsAreOpen;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    #[Test]
    public function command_will_trigger_notification_for_approved_and_not_shared_conference(): void
    {
        Notification::fake();
        $user = User::factory()->wantsNotifications()->create();
        $conference = Conference::factory()->approved()->notShared()->create();

        Artisan::call('symposium:notifyCfps');

        $this->assertUserNotifiedOfCfp($user, $conference);
        $this->assertTrue(Conference::first()->is_shared);
    }

    #[Test]
    public function command_will_not_trigger_notification_for_unapproved_conference(): void
    {
        Notification::fake();
        $user = User::factory()->create();
        Conference::factory()->notApproved()->create();

        Artisan::call('symposium:notifyCfps');

        Notification::assertNotSentTo([$user], CFPsAreOpen::class);
    }

    #[Test]
    public function command_will_not_trigger_notification_for_already_shared_conference(): void
    {
        Notification::fake();
        $user = User::factory()->create();
        Conference::factory()->notApproved()->notShared()->create();

        Artisan::call('symposium:notifyCfps');

        Notification::assertNotSentTo([$user], CFPsAreOpen::class);
    }

    #[Test]
    public function command_will_not_trigger_notification_for_closed_cfp(): void
    {
        Notification::fake();
        $user = User::factory()->wantsNotifications()->create();
        Conference::factory()->approved()->closedCFP()->create();

        Artisan::call('symposium:notifyCfps');

        Notification::assertNotSentTo([$user], CFPsAreOpen::class);
    }

    #[Test]
    public function command_will_not_trigger_notification_if_no_cfp_dates_given(): void
    {
        Notification::fake();
        $user = User::factory()->wantsNotifications()->create();
        Conference::factory()->approved()->noCfpDates()->create();

        Artisan::call('symposium:notifyCfps');

        Notification::assertNotSentTo([$user], CFPsAreOpen::class);
    }

    #[Test]
    public function command_will_not_trigger_notification_for_opt_out_user(): void
    {
        Notification::fake();
        $user = User::factory()->create();
        Conference::factory()->approved()->create();

        Artisan::call('symposium:notifyCfps');

        Notification::assertNotSentTo([$user], CFPsAreOpen::class);
    }

    public function assertUserNotifiedOfCfp($user, $conference)
    {
        Notification::assertSentTo($user, CFPsAreOpen::class, function ($notification) use ($conference) {
            return $notification->conferences->pluck('id')->contains($conference->id);
        });
    }
}
