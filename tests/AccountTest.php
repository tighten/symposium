<?php

use App\User;
use Laracasts\TestDummy\Factory;
use Illuminate\Support\Facades\Notification;

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
        $user = Factory::create('user', [
            'password' => bcrypt('super-secret'),
        ]);

        $this->visit('login')
            ->type($user->email, '#email')
            ->type('super-secret', '#password')
            ->press('Log in')
            ->seePageIs('dashboard');
    }

    /** @test */
    function user_can_update_their_profile()
    {
        $user = Factory::create('user');

        $this->actingAs($user)
            ->visit('/account/edit')
            ->type('Kevin Bacon', '#name')
            ->type('KevinBacon@yahoo.com', '#email')
            ->type('haxTh1sn00b', '#password')
            ->select(true, '#enable_profile')
            ->select(true, '#allow_profile_contact')
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
        ]);
    }

    /** @test */
    function user_can_update_their_profile_picture()
    {
        $image = __DIR__.'/stubs/test.jpg';
        $user = Factory::create('user', [
            'name' => 'Kevin Smith',
        ]);

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
        $user = Factory::create('user');

        $this->visit('/password/reset')
            ->type($user->email, '#email')
            ->press('Send Password Reset Link');

            Notification::assertSentTo($user, \Illuminate\Auth\Notifications\ResetPassword::class);
    }

    /** @test */
    function user_can_reset_their_password_from_email_link()
    {
        $this->disableExceptionHandling();
        $user = Factory::create('user');
        $this->post('/password/email', [
            'email' => $user->email,
            '_token' => csrf_token(),
        ]);

        $reset_token = DB::table('password_resets')->where('email', $user->email)->pluck('token')->first();

        $this->visit(route('password.reset', $reset_token))
            ->type($user->email, '#email')
            ->type('h4xmahp4ssw0rdn00bz', '#password')
            ->type('h4xmahp4ssw0rdn00bz', '#password_confirmation')
            ->press('Reset Password')
            ->seePageIs('/dashboard');

        $this->visit('log-out');

        $this->visit('login')
            ->type($user->email, '#email')
            ->type('h4xmahp4ssw0rdn00bz', '#password')
            ->press('Log in');
    }

    /** @test */
    function users_can_delete_their_accounts()
    {
        $user = Factory::create('user');

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
        $user = Factory::create('user');
        $talk = Factory::build('talk');
        $talkRevision = Factory::build('talkRevision');
        $bio = Factory::build('bio');
        $conference = Factory::build('conference');

        $user->talks()->save($talk);
        $talk->revisions()->save($talkRevision);
        $user->bios()->save($bio);
        $user->conferences()->save($conference);

        $otherUser = Factory::create('user');
        $favoriteConference = Factory::build('conference');
        $otherUser->conferences()->save($conference);
        $user->favoritedConferences()->save($favoriteConference);

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

      //  $this->dontSeeInDatabase('conferences', [
      //      'id' => $conference->id,
      //  ]);

        $this->dontSeeInDatabase('favorites', [
            'user_id' => $user->id,
            'conference_id' => $favoriteConference->id,
        ]);
    }
}
