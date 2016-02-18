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
        $favoriteConference = Factory::build('conference');

        $user->talks()->save($talk);
        $talk->revisions()->save($talkRevision);
        $user->bios()->save($bio);
        $user->conferences()->save($conference);
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
            'author_id' => $talk->author_id,
            'public' => $talk->public,
        ]);

        $this->dontSeeInDatabase('bios', [
            'id' => $bio->id,
            'nickname' => $bio->nickname,
            'body' => $bio->body,
            'user_id' => $user->id,
            'public' => $bio->public,
        ]);

        $this->dontSeeInDatabase('conferences', [
            'id' => $conference->id,
            'title' => $conference->title,
            'description' => $conference->description,
            'url' => $conference->url,
            'author_id' => $user->id,
            'starts_at' => $conference->starts_at->format('D M j, Y'),
            'ends_at' => $conference->ends_at->format('D M j, Y'),
            'cfp_starts_at' => $conference->cfp_starts_at->toFormattedDateString(),
            'cfp_ends_at' => $conference->cfp_ends_at->toFormattedDateString(),
            'joindin_id' => $conference->joindin_id,
        ]);

        $this->dontSeeInDatabase('favorites', [
            'user_id' => $user->id,
            'conference_id' => $conference->id,
        ]);
    }
}
