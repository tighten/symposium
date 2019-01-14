<?php

use App\Conference;
use App\Events\ConferenceCreated;
use App\Listeners\SendNotificationForOpenCFPs;
use App\Notifications\CFPIsOpen;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;

class NotificationTest extends IntegrationTestCase
{
    /** @test */
    function if_approved_conference_is_created_users_are_notified()
    {
        factory(App\User::class)->states('wantsNotifications')->create();

        Notification::fake();
        $user = factory(App\User::class)->states('wantsNotifications')->create();
        $conference = factory(Conference::class)->create(['approved' => true]);

        event(new ConferenceCreated($conference));

        $conference = Conference::first();

        Notification::assertSentTo($user, CFPIsOpen::class, function ($notification) use ($conference) {
            return $notification->conference->id === $conference->id;
        });

        $this->assertTrue(Conference::first()->shared);
    }

    /** @test */
    function users_are_not_notified_for_closed_cfp()
    {
        Notification::fake();
        $user = factory(App\User::class)->create();
        $conference = factory(Conference::class)->states('closedCFP')->create(['approved' => true]);

        event(new ConferenceCreated($conference));

        Notification::assertNotSentTo($user, CFPIsOpen::class);
    }

    /** @test */
    function users_are_not_notified_if_no_cfp_dates_given()
    {
        Notification::fake();
        $user = factory(App\User::class)->create();
        $conference = factory(Conference::class)->states('noCFPDates')->create(['approved' => true]);

        event(new ConferenceCreated($conference));

        Notification::assertNotSentTo($user, CFPIsOpen::class);
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

        Notification::assertNotSentTo($user, CFPIsOpen::class);
    }

    /** @test */
    function command_will_trigger_notification_for_approved_and_not_shared_conference()
    {
        Notification::fake();
        factory(App\User::class)->states('wantsNotifications')->create();
        $conference = factory(Conference::class)->create(['approved' => true, 'shared' => false]);

        Artisan::call('symposium:notifyCfps');

        Notification::assertSentTo(User::wantsNotifications()->get(), CFPIsOpen::class, function ($notification) use ($conference) {
            return $notification->conference->id === $conference->id;
        });

        $this->assertTrue(Conference::first()->shared);
    }

    /** @test */
    function command_will_not_trigger_notification_for_unapproved_conference()
    {
        Notification::fake();
        $user = factory(App\User::class)->create();
        factory(Conference::class)->create(['approved' => false]);

        Artisan::call('symposium:notifyCfps');

        Notification::assertNotSentTo([$user], CFPIsOpen::class);
    }

    /** @test */
    function command_will_not_trigger_notification_for_already_shared_conference()
    {
        Notification::fake();
        $user = factory(App\User::class)->create();
        factory(Conference::class)->create([
            'approved' => false,
            'shared' => false
        ]);

        Artisan::call('symposium:notifyCfps');

        Notification::assertNotSentTo([$user], CFPIsOpen::class);
    }

    /** @test */
    function command_will_not_trigger_notification_for_closed_cfp()
    {
        Notification::fake();
        $user = factory(App\User::class)->states('wantsNotifications')->create();
        factory(Conference::class)->states('closedCFP')->create(['approved' => true]);

        Artisan::call('symposium:notifyCfps');

        Notification::assertNotSentTo([$user], CFPIsOpen::class);
    }

    /** @test */
    function command_will_not_trigger_notification_for_opt_out_user()
    {
        Notification::fake();
        $user = factory(App\User::class)->create();
        factory(Conference::class)->create(['approved' => true]);

        Artisan::call('symposium:notifyCfps');

        Notification::assertNotSentTo([$user], CFPIsOpen::class);
    }
}
