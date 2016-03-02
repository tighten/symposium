<?php

use Laracasts\TestDummy\Factory;

class AccountTest extends IntegrationTestCase
{
    public function test_it_deletes_the_user_account()
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

    public function test_it_deletes_users_associated_entities()
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
