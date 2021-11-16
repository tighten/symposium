<?php

namespace Tests\Feature;

use App\Models\Acceptance;
use App\Models\Conference;
use App\Models\Submission;
use App\Models\Talk;
use App\Models\TalkRevision;
use App\Models\User;
use Carbon\Carbon;
use Tests\IntegrationTestCase;

class TalkTest extends IntegrationTestCase
{
    /** @test */
    function it_shows_the_talk_title_on_its_page()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->create();
        $talk = Talk::factory()->create(['author_id' => $user->id]);
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);

        $response = $this->actingAs($user)
            ->get("talks/{$talk->id}");

        $response->assertSee($revision->title);
    }

    /** @test */
    function user_talks_are_sorted_alphabetically()
    {
        $user = User::factory()->create();
        $talk1 = Talk::factory()->create(['author_id' => $user->id]);
        $revision1 = TalkRevision::factory()->create(['title' => 'zyxwv']);
        $talk1->revisions()->save($revision1);

        $talk2 = Talk::factory()->create(['author_id' => $user->id]);
        $revision2 = TalkRevision::factory()->create(['title' => 'abcde']);
        $talk2->revisions()->save($revision2);

        $talks = $user->talks;

        $this->assertEquals('abcde', $talks->first()->current()->title);
        $this->assertEquals('zyxwv', $talks->last()->current()->title);
    }

    /** @test */
    function user_talks_json_encode_without_keys()
    {
        $user = User::factory()->create();

        $talk1 = Talk::factory()->create(['author_id' => $user->id]);
        $revision1 = TalkRevision::factory()->create(['title' => 'zyxwv']);
        $talk1->revisions()->save($revision1);

        $talk2 = Talk::factory()->create(['author_id' => $user->id]);
        $revision2 = TalkRevision::factory()->create(['title' => 'abcde']);
        $talk2->revisions()->save($revision2);

        $json = json_encode($user->talks);

        $this->assertTrue(is_array(json_decode($json)));
    }

    /** @test */
    function user_can_create_a_talk()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('talks', [
                'title' => 'Your Best Talk Now',
                'type' => 'keynote',
                'level' => 'intermediate',
                'description' => 'No, really.',
                'length' => '123',
                'slides' => 'http://www.google.com/slides',
                'organizer_notes' => "It'll be awesome!",
            ]);

        $this->assertDatabaseHas('talk_revisions', [
            'title' => 'Your Best Talk Now',
            'type' => 'keynote',
            'level' => 'intermediate',
            'description' => 'No, really.',
            'length' => '123',
            'slides' => 'http://www.google.com/slides',
            'organizer_notes' => "It'll be awesome!",
        ]);

        $talk = Talk::first();

        $this->get("talks/{$talk->id}")
            ->assertSee('Your Best Talk Now')
            ->assertSee('No, really.');
    }

    /** @test */
    function user_can_delete_a_talk()
    {
        $user = User::factory()->create();
        $talk = Talk::factory()->create(['author_id' => $user->id]);
        TalkRevision::factory()->create([
            'title' => 'zyxwv',
            'talk_id' => $talk->id,
        ]);

        $this->be($user);

        $this->get("talks/{$talk->id}/delete");

        $this->assertEquals(0, Talk::count());
        $this->assertEquals(0, TalkRevision::count());
    }

    /** @test */
    function user_can_save_a_new_revision_of_a_talk()
    {
        $user = User::factory()->create();
        $talk = Talk::factory()->create(['author_id' => $user->id]);
        $revision = TalkRevision::factory()->create([
            'title' => 'old title',
            'created_at' => Carbon::now()->subMinute(),
        ]);
        $talk->revisions()->save($revision);

        $this->actingAs($user)
            ->put("/talks/{$talk->id}", array_merge($revision->toArray(), [
                'title' => 'New',
            ]));

        $talk = Talk::first();

        $this->assertEquals('New', $talk->current()->title);
        $this->assertEquals('old title', $talk->revisions->last()->title);
    }

    /** @test */
    function scoping_talks_where_submitted()
    {
        [$talkRevisionA, $talkRevisionB] = TalkRevision::factory()->count(2)->create();
        $conference = Conference::factory()->create();
        Submission::factory()->create([
            'talk_revision_id' => $talkRevisionA->id,
            'conference_id' => $conference->id,
        ]);

        $submittedTalkIds = Talk::submitted()->get()->pluck('id');

        $this->assertContains($talkRevisionA->talk_id, $submittedTalkIds);
        $this->assertNotContains($talkRevisionB->talk_id, $submittedTalkIds);
    }

    /** @test */
    function scoping_talks_where_accepted()
    {
        [$talkRevisionA, $talkRevisionB] = TalkRevision::factory()->count(2)->create();
        $conference = Conference::factory()->create();
        TalkRevision::all()->each(function ($talkRevision) use ($conference) {
            Submission::factory()->create([
                'talk_revision_id' => $talkRevision->id,
                'conference_id' => $conference->id,
            ]);
        });

        Acceptance::factory()->create([
            'talk_revision_id' => $talkRevisionA->id,
            'conference_id' => $conference->id,
        ]);

        $acceptedTalkIds = Talk::accepted()->get()->pluck('id');

        $this->assertContains($talkRevisionA->talk_id, $acceptedTalkIds);
        $this->assertNotContains($talkRevisionB->talk_id, $acceptedTalkIds);
    }
}
