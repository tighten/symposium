<?php

use App\User;
use Laracasts\TestDummy\Factory;
use MailThief\Testing\InteractsWithMail;

class AccountTest extends IntegrationTestCase
{
    use InteractsWithMail;

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
            'name' => 'Joe Schmoe'
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
            'password' => bcrypt('super-secret')
        ]);

        $this->visit('login')
            ->type($user->email, '#email')
            ->type('super-secret', '#password')
            ->press('Log in')
            ->seePageIs('dashboard');
    }

    /** @test */
    function password_reset_emails_are_sent_for_valid_users()
    {
        $this->markTestIncomplete('Wait for Laravel 5.3');

        $user = Factory::create('user');

        $this->visit('password/email')
            ->type($user->email, '#email')
            ->press('Send Password Reset Link');

        $this->seeMessageFor($user->email);
        $this->assertTrue($this->lastMessage()->contains('Password or whatever should be here'));
    }

    // @todo: Also test the round two is triggered correctly

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

//        $this->dontSeeInDatabase('conferences', [
//            'id' => $conference->id,
//        ]);

        $this->dontSeeInDatabase('favorites', [
            'user_id' => $user->id,
            'conference_id' => $favoriteConference->id,
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
