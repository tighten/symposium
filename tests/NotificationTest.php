<?php

use App\User;
use Carbon\Carbon;
use App\Conference;
use App\Events\ConferenceCreated;
use App\Notifications\CFPsAreOpen;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use App\Listeners\SendNotificationForOpenCFPs;

class NotificationTest extends IntegrationTestCase
{
    /** @test */
    function if_approved_conference_is_created_users_are_notified()
    {
        factory(App\User::class)->states('wantsNotifications')->create();

        Notification::fake();
        $user = factory(App\User::class)->states('wantsNotifications')->create();
        $conference = factory(Conference::class)->create(['is_approved' => true]);

        event(new ConferenceCreated($conference));

        $this->assertUserNotifiedOfCfp($user, $conference);
        $this->assertTrue($conference->is_shared);
    }

    /** @test */
    function users_are_not_notified_for_closed_cfp()
    {
        Notification::fake();
        $user = factory(App\User::class)->create();
        $conference = factory(Conference::class)->states('closedCFP')->create(['is_approved' => true]);

        event(new ConferenceCreated($conference));

        Notification::assertNotSentTo($user, CFPsAreOpen::class);
    }

    /** @test */
    function users_are_not_notified_if_no_cfp_dates_given()
    {
        Notification::fake();
        $user = factory(App\User::class)->create();
        $conference = factory(Conference::class)->states('noCFPDates')->create(['is_approved' => true]);

        event(new ConferenceCreated($conference));

        Notification::assertNotSentTo($user, CFPsAreOpen::class);
    }

    /** @test */
    function users_are_not_notified_for_default_conference_creation()
    {
        Notification::fake();
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->visit('/conferences/create')
            ->type('Das Conf', '#title')
            ->type('A very good conference about things', '#description')
            ->type('http://dasconf.org', '#url')
            ->type(Carbon::today()->addDays(10)->toDateString(), '#starts_at')
            ->type(Carbon::today()->toDateString(), '#cfp_starts_at')
            ->type(Carbon::tomorrow()->toDateString(), '#cfp_ends_at')
            ->press('Create');

        Notification::assertNotSentTo($user, CFPsAreOpen::class);
    }

    /** @test */
    function command_will_trigger_notification_for_approved_and_not_shared_conference()
    {
        Notification::fake();
        $user = factory(App\User::class)->states('wantsNotifications')->create();
        $conference = factory(Conference::class)->create(['is_approved' => true, 'is_shared' => false]);

        Artisan::call('symposium:notifyCfps');

        $this->assertUserNotifiedOfCfp($user, $conference);
        $this->assertTrue(Conference::first()->is_shared);
    }

    /** @test */
    function command_will_not_trigger_notification_for_unapproved_conference()
    {
        Notification::fake();
        $user = factory(App\User::class)->create();
        factory(Conference::class)->create(['is_approved' => false]);

        Artisan::call('symposium:notifyCfps');

        Notification::assertNotSentTo([$user], CFPsAreOpen::class);
    }

    /** @test */
    function command_will_not_trigger_notification_for_already_shared_conference()
    {
        Notification::fake();
        $user = factory(App\User::class)->create();
        factory(Conference::class)->create([
            'is_approved' => false,
            'is_shared' => false
        ]);

        Artisan::call('symposium:notifyCfps');

        Notification::assertNotSentTo([$user], CFPsAreOpen::class);
    }

    /** @test */
    function command_will_not_trigger_notification_for_closed_cfp()
    {
        Notification::fake();
        $user = factory(App\User::class)->states('wantsNotifications')->create();
        factory(Conference::class)->states('closedCFP')->create(['is_approved' => true]);

        Artisan::call('symposium:notifyCfps');

        Notification::assertNotSentTo([$user], CFPsAreOpen::class);
    }

    /** @test */
    function command_will_not_trigger_notification_for_opt_out_user()
    {
        Notification::fake();
        $user = factory(App\User::class)->create();
        factory(Conference::class)->create(['is_approved' => true]);

        Artisan::call('symposium:notifyCfps');

        Notification::assertNotSentTo([$user], CFPsAreOpen::class);
    }

    private function assertUserNotifiedOfCfp($user, $conference)
    {
        Notification::assertSentTo($user, CFPsAreOpen::class, function ($notification) use ($conference) {
            return $notification->conferences->pluck('id')->contains($conference->id);
        });
    }
}
