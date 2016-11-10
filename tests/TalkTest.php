<?php

use App\Talk;
use Carbon\Carbon;
use Laracasts\TestDummy\Factory;

class TalkTest extends IntegrationTestCase
{
    /** @test */
    function it_shows_the_talk_title_on_its_page()
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
    function user_talks_are_sorted_alphabetically()
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
    function user_talks_json_encode_without_keys()
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

    /** @test */
    function user_can_create_a_talk()
    {
        $user = Factory::create('user');

        $this->be($user);

        $data = [
            'title' => 'Your Best Talk Now',
            'type' => 'keynote',
            'level' => 'intermediate',
            'description' => 'No, really.',
            'length' => '123',
            'slides' => 'http://www.google.com/slides',
            'organizer_notes' => "It'll be awesome!"
        ];

        $this->post('talks', $data);

        $this->seeInDatabase('talk_revisions', $data);

        $talk = Talk::first();

        $this->visit('talks/' . $talk->id)
            ->see('Your Best Talk Now')
            ->see('No, really.');
    }
}
