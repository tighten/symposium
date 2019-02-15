<?php

use App\Bio;
use App\User;
use App\Talk;
use App\Conference;
use App\TalkRevision;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;

class AccountTest extends IntegrationTestCase
{
    /** @test */
    function users_can_sign_up()
    {
        $this->visit('register')
            ->type('email@email.com', '#email')
            ->type('schmassword', '#password')
            ->type('Joe Schmoe', '#name')
            ->press('Sign up')
            ->seePageIs('dashboard');

        $this->seeInDatabase('users', [
            'email' => 'email@email.com',
            'name' => 'Joe Schmoe',
        ]);
    }

    /** @test */
    function invalid_signups_dont_proceed()
    {
        $this->visit('register')
            ->press('Sign up')
            ->seePageIs('register')
            ->see('The name field is required')
            ->see('The password field is required')
            ->see('The email field is required');

        $this->assertEquals(0, User::all()->count());
    }

    /** @test */
    function users_can_log_in()
    {
        $user = factory(User::class)->create(['password' => bcrypt('super-secret')]);

        $this->visit('login')
            ->type($user->email, '#email')
            ->type('super-secret', '#password')
            ->press('Log in')
            ->seePageIs('dashboard');
    }

    /** @test */
    function user_can_update_their_profile()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->visit('/account/edit')
            ->type('Kevin Bacon', '#name')
            ->type('KevinBacon@yahoo.com', '#email')
            ->type('haxTh1sn00b', '#password')
            ->select(true, '#enable_profile')
            ->select(true, '#allow_profile_contact')
            ->select(true, '#wants_notifications')
            ->type('kevin_rox', '#profile_slug')
            ->type('It has been so long since I was in an X-Men movie', '#profile_intro')
            ->press('Save')
            ->seePageIs('account');

        $this->seeInDatabase('users', [
            'name' => 'Kevin Bacon',
            'email' => 'KevinBacon@yahoo.com',
            'enable_profile' => 1,
            'allow_profile_contact' => 1,
            'profile_slug' => 'kevin_rox',
            'profile_intro' => 'It has been so long since I was in an X-Men movie',
            'wants_notifications' => 1
        ]);
    }

    /** @test */
    function user_can_update_their_profile_picture()
    {
        $image = __DIR__.'/stubs/test.jpg';
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->visit('/account/edit')
            ->attach($image, '#profile_picture')
            ->press('Save');

        $user->fresh();
        $this->assertNotTrue($user->profile_picture, null);
    }

    /** @test */
    function password_reset_emails_are_sent_for_valid_users()
    {
        Notification::fake();
        $user = factory(User::class)->create();

        $this->visit('/password/reset')
            ->type($user->email, '#email')
            ->press('Send Password Reset Link');

        Notification::assertSentTo($user, \Illuminate\Auth\Notifications\ResetPassword::class);
    }

    /** @test */
    function user_can_reset_their_password_from_email_link()
    {
        $this->disableExceptionHandling();

        Notification::fake();

        $user = factory(User::class)->create();
        $token = null;

        $this->post('/password/email', [
            'email' => $user->email,
            '_token' => csrf_token(),
        ]);

        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            function ($notification, $channels) use (&$token) {
                $token = $notification->token;

                return true;
            }
        );

        $this->visit(route('password.reset', $token))
            ->type($user->email, '#email')
            ->type('h4xmahp4ssw0rdn00bz', '#password')
            ->type('h4xmahp4ssw0rdn00bz', '#password_confirmation')
            ->press('Reset Password')
            ->seePageIs('/dashboard');

        $this->visit('log-out');

        $this->visit('login')
            ->type($user->email, '#email')
            ->type('h4xmahp4ssw0rdn00bz', '#password')
            ->press('Log in')
            ->seePageIs('dashboard');
    }

    /** @test */
    function users_can_delete_their_accounts()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
             ->visit('account/delete')
             ->press('Yes')
             ->seePageIs('/')
             ->see('Successfully deleted account.');

        $this->dontSeeInDatabase('users', [
            'email' => $user->email,
        ]);
    }

    /** @test */
    function deleting_a_user_deletes_its_associated_entities()
    {
        $user = factory(User::class)->create();
        $talk = factory(Talk::class)->create(['author_id' => $user->id]);
        $talkRevision = factory(TalkRevision::class)->create();
        $bio = factory(Bio::class)->create();
        $conference = factory(Conference::class)->create();

        $user->talks()->save($talk);
        $talk->revisions()->save($talkRevision);
        $user->bios()->save($bio);
        $user->conferences()->save($conference);

        $otherUser = factory(User::class)->create();
        $favoriteConference = factory(Conference::class)->create();

        $otherUser->conferences()->save($conference);
        $user->dismissedConferences()->save($dismissedConference);

        $this->actingAs($user)
             ->visit('account/delete')
             ->press('Yes')
             ->seePageIs('/')
             ->see('Successfully deleted account.');

        $this->dontSeeInDatabase('users', [
            'email' => $user->email,
        ]);

        $this->dontSeeInDatabase('talks', [
            'id' => $talk->id,
        ]);

        $this->dontSeeInDatabase('bios', [
            'id' => $bio->id,
        ]);

        // $this->dontSeeInDatabase('conferences', [
        //     'id' => $conference->id,
        // ]);

        $this->dontSeeInDatabase('dismissed_conferences', [
            'user_id' => $user->id,
            'conference_id' => $dismissedConference->id,
        ]);
    }

    /** @test */
    function users_can_dismiss_a_conference()
    {
        $user = Factory::create('user');
        $conference = Factory::build('conference');
        $user->conferences()->save($conference);

        $this->actingAs($user)
            ->visit("conferences/{$conference->id}/dismiss");

        $this->seeInDatabase('dismissed_conferences', [
            'user_id' => $user->id,
            'conference_id' => $conference->id
        ]);
    }

    /** @test */
    function users_can_undismiss_a_conference()
    {
        $user = Factory::create('user');
        $conference = Factory::build('conference');
        $user->conferences()->save($conference);

        $this->actingAs($user)
            ->visit("conferences/{$conference->id}/dismiss");

        $this->seeInDatabase('dismissed_conferences', [
            'user_id' => $user->id,
            'conference_id' => $conference->id
        ]);

        $this->actingAs($user)
            ->visit("conferences/{$conference->id}/undismiss");

        $this->notSeeInDatabase('dismissed_conferences', [
            'user_id' => $user->id,
            'conference_id' => $conference->id
        ]);
    }
}
