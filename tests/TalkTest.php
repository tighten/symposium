<?php

namespace Tests;

use App\Conference;
use App\Talk;
use App\TalkRevision;
use App\User;
use Carbon\Carbon;

class TalkTest extends IntegrationTestCase
{
    /** @test */
    public function it_shows_the_talk_title_on_its_page()
    {
        $user = factory(User::class)->create();
        $conference = factory(Conference::class)->create();
        $talk = factory(Talk::class)->create(['author_id' => $user->id]);
        $revision = factory(TalkRevision::class)->create();
        $talk->revisions()->save($revision);

        $this->actingAs($user)
             ->visit('talks/'.$talk->id)
             ->see($revision->title);
    }

    /** @test */
    public function user_talks_are_sorted_alphabetically()
    {
        $user = factory(User::class)->create();
        $talk1 = factory(Talk::class)->create(['author_id' => $user->id]);
        $revision1 = factory(TalkRevision::class)->create(['title' => 'zyxwv']);
        $talk1->revisions()->save($revision1);

        $talk2 = factory(Talk::class)->create(['author_id' => $user->id]);
        $revision2 = factory(TalkRevision::class)->create(['title' => 'abcde']);
        $talk2->revisions()->save($revision2);

        $talks = $user->talks;

        $this->assertEquals('abcde', $talks->first()->current()->title);
        $this->assertEquals('zyxwv', $talks->last()->current()->title);
    }

    /** @test */
    public function user_talks_json_encode_without_keys()
    {
        $user = factory(User::class)->create();

        $talk1 = factory(Talk::class)->create(['author_id' => $user->id]);
        $revision1 = factory(TalkRevision::class)->create(['title' => 'zyxwv']);
        $talk1->revisions()->save($revision1);

        $talk2 = factory(Talk::class)->create(['author_id' => $user->id]);
        $revision2 = factory(TalkRevision::class)->create(['title' => 'abcde']);
        $talk2->revisions()->save($revision2);

        $json = json_encode($user->talks);

        $this->assertTrue(is_array(json_decode($json)));
    }

    /** @test */
    public function user_can_create_a_talk()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->visit('/talks/create')
            ->type('Your Best Talk Now', '#title')
            ->select('keynote', '#type')
            ->select('intermediate', '#level')
            ->type('No, really.', '#description')
            ->type('123', '#length')
            ->type('http://www.google.com/slides', '#slides')
            ->type("It'll be awesome!", '#organizer_notes')
            ->press('Create');

        $this->seeInDatabase('talk_revisions', [
            'title' => 'Your Best Talk Now',
            'type' => 'keynote',
            'level' => 'intermediate',
            'description' => 'No, really.',
            'length' => '123',
            'slides' => 'http://www.google.com/slides',
            'organizer_notes' => "It'll be awesome!",
        ]);

        $talk = Talk::first();

        $this->visit('talks/'.$talk->id)
            ->see('Your Best Talk Now')
            ->see('No, really.');
    }

    /** @test */
    public function user_can_delete_a_talk()
    {
        $user = factory(User::class)->create();
        $talk = factory(Talk::class)->create(['author_id' => $user->id]);
        factory(TalkRevision::class)->create([
            'title' => 'zyxwv',
            'talk_id' => $talk->id,
        ]);

        $this->be($user);

        $this->visit('talks/'.$talk->id.'/delete');

        $this->assertEquals(0, Talk::count());
        $this->assertEquals(0, TalkRevision::count());
    }

    /** @test */
    public function user_can_save_a_new_revision_of_a_talk()
    {
        $user = factory(User::class)->create();
        $talk = factory(Talk::class)->create(['author_id' => $user->id]);
        $revision = factory(TalkRevision::class)->create([
            'title' => 'old title',
            'created_at' => Carbon::now()->subMinute(),
        ]);
        $talk->revisions()->save($revision);

        $this->actingAs($user)
            ->visit('/talks/'.$talk->id.'/edit')
            ->type('New', '#title')
            ->select($revision->type, '#type')
            ->select($revision->level, '#level')
            ->type($revision->description, '#description')
            ->type($revision->length, '#length')
            ->type($revision->slides, '#slides')
            ->type($revision->organizer_notes, '#organizer_notes')
            ->press('Update');

        $talk = Talk::first();

        $this->assertEquals('New', $talk->current()->title);
        $this->assertEquals('old title', $talk->revisions->last()->title);
    }
}
