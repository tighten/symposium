<?php

use App\User;
use Laracasts\TestDummy\Factory;

class AccountTest extends IntegrationTestCase
{
    /** @test */
    function users_can_sign_up()
    {
        $this->visit('sign-up')
            ->type('email@email.com', '#email')
            ->type('schmassword', '#password')
            ->type('Joe Schmoe', '#name')
            ->press('Sign up');

        $this->seeInDatabase('users', [
            'email' => 'email@email.com',
            'name' => 'Joe Schmoe'
        ]);
    }

    /** @test */
    function invalid_signups_dont_proceed()
    {
        $this->visit('sign-up')
            ->press('Sign up')
            ->seePageIs('sign-up')
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

        $this->visit('log-in')
            ->type($user->email, '#email')
            ->type('super-secret', '#password')
            ->press('Log in')
            ->seePageIs('dashboard');
    }

    // @todo: reset password

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
}
