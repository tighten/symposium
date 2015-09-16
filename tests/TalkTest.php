<?php

use Laracasts\TestDummy\Factory;
use Carbon\Carbon;

class TalkTest extends IntegrationTestCase
{
    /** @test */
    public function it_shows_the_talk_title_on_its_page()
    {
        $user = Factory::create('user');
        $conference = Factory::create('conference');
        $talk = Factory::create('talk', [
            'author_id' => $user->id
        ]);
        $revision = Factory::create('talkRevision');
        $talk->revisions()->save($revision);

        $this->actingAs($user)
             ->visit('talks/' . $talk->id)
             ->see($revision->title);
    }
}
