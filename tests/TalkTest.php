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

    /** @test */
    public function user_talks_are_sorted_alphabetically()
    {
        $user = Factory::create('user');
        $talk1 = Factory::create('talk', [
            'author_id' => $user->id
        ]);
        $revision1 = Factory::create('talkRevision', [
            'title' => 'zyxwv'
        ]);
        $talk1->revisions()->save($revision1);

        $talk2 = Factory::create('talk', [
            'author_id' => $user->id
        ]);
        $revision2 = Factory::create('talkRevision', [
            'title' => 'abcde'
        ]);
        $talk2->revisions()->save($revision2);

        $talks = $user->talks;

        $this->assertEquals('abcde', $talks->first()->current()->title);
        $this->assertEquals('zyxwv', $talks->last()->current()->title);
    }

    /** @test */
    public function user_talks_json_encode_without_keys()
    {
        $user = Factory::create('user');

        $talk1 = Factory::create('talk', ['author_id' => $user->id]);
        $revision1 = Factory::create('talkRevision', ['title' => 'zyxwv']);
        $talk1->revisions()->save($revision1);

        $talk2 = Factory::create('talk', ['author_id' => $user->id]);
        $revision2 = Factory::create('talkRevision', ['title' => 'abcde']);
        $talk2->revisions()->save($revision2);

        $json = json_encode($user->talks);

        $this->assertTrue(is_array(json_decode($json)));
    }
}
