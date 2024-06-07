<?php

namespace Tests\Feature;

use App\Models\Acceptance;
use App\Models\Conference;
use App\Models\Submission;
use App\Models\Talk;
use App\Models\TalkRevision;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class TalkTest extends TestCase
{
    /** @test */
    function archived_talks_are_not_included_on_the_index_page()
    {
        $user = User::factory()->create();
        Talk::factory()
            ->author($user)
            ->revised(['title' => 'my active talk'])
            ->create();
        Talk::factory()
            ->author($user)
            ->revised(['title' => 'my archived talk'])
            ->archived()
            ->create();

        $response = $this->actingAs($user)
            ->get('talks')
            ->assertSuccessful();

        $response->assertSee('my active talk');
        $response->assertDontSee('my archived talk');
    }

    /** @test */
    function active_talks_are_not_included_on_the_archived_index_page()
    {
        $user = User::factory()->create();
        Talk::factory()
            ->author($user)
            ->revised(['title' => 'my active talk'])
            ->create();
        Talk::factory()
            ->author($user)
            ->revised(['title' => 'my archived talk'])
            ->archived()
            ->create();

        $response = $this->actingAs($user)
            ->get('archive')
            ->assertSuccessful();

        $response->assertSee('my archived talk');
        $response->assertDontSee('my active talk');
    }

    /** @test */
    public function it_shows_the_talk_title_on_its_page()
    {
        $user = User::factory()->create();
        Conference::factory()->create();
        $talk = Talk::factory()->author($user)->create();
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);

        $response = $this->actingAs($user)
            ->get("talks/{$talk->id}");

        $response->assertSee($revision->title);
    }

    /** @test */
    public function user_talks_are_sorted_alphabetically()
    {
        $user = User::factory()->create();
        $talk1 = Talk::factory()->author($user)->revised(['title' => 'zyxwv'])->create();
        $talk2 = Talk::factory()->author($user)->revised(['title' => 'abcde'])->create();

        $talks = $user->talks()->withCurrentRevision()->get();

        $this->assertEquals('abcde', $talks->sortByTitle()->first()->currentRevision->title);
        $this->assertEquals('zyxwv', $talks->sortByTitle()->last()->currentRevision->title);
    }

    /** @test */
    public function user_talks_json_encode_without_keys()
    {
        $user = User::factory()->create();

        $talk1 = Talk::factory()->author($user)->create();
        $revision1 = TalkRevision::factory()->create(['title' => 'zyxwv']);
        $talk1->revisions()->save($revision1);

        $talk2 = Talk::factory()->author($user)->create();
        $revision2 = TalkRevision::factory()->create(['title' => 'abcde']);
        $talk2->revisions()->save($revision2);

        $json = json_encode($user->talks);

        $this->assertTrue(is_array(json_decode($json)));
    }

    /** @test */
    public function user_can_create_a_talk()
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
                'public' => '1',
            ]);

        $this->assertDatabaseHas(TalkRevision::class, [
            'title' => 'Your Best Talk Now',
            'type' => 'keynote',
            'level' => 'intermediate',
            'description' => 'No, really.',
            'length' => '123',
            'slides' => 'http://www.google.com/slides',
            'organizer_notes' => "It'll be awesome!",
        ]);

        $talk = Talk::first();

        $this->assertTrue($talk->public);

        $this->get("talks/{$talk->id}")
            ->assertSee('Your Best Talk Now')
            ->assertSee('No, really.');
    }

    /** @test */
    function new_talks_must_include_required_fields()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('talks', []);

        $response->assertInvalid([
            'title',
            'type',
            'level',
            'length',
            'organizer_notes',
            'description',
            'public',
        ]);
    }

    /** @test */
    function new_talks_must_include_a_valid_length()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('talks', [
            'title' => 'My invalid talk',
            'type' => 'keynote',
            'level' => 'intermediate',
            'length' => 'invalid',
            'organizer_notes' => "It'll be awesome!",
            'description' => 'No, really.',
            'public' => '1',
        ]);

        $response->assertInvalid(['length']);
    }

    /** @test */
    function new_talks_with_slides_must_include_a_valid_slides_url()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('talks', [
            'title' => 'My invalid talk',
            'type' => 'keynote',
            'level' => 'intermediate',
            'length' => '123',
            'organizer_notes' => "It'll be awesome!",
            'description' => 'No, really.',
            'public' => '1',
            'slides' => 'invalid url',
        ]);

        $response->assertInvalid(['slides']);
    }

    /** @test */
    public function user_can_delete_a_talk()
    {
        $user = User::factory()->create();
        $talk = Talk::factory()->author($user)->create();
        $talkRevision = TalkRevision::factory()->create([
            'title' => 'zyxwv',
            'talk_id' => $talk->id,
        ]);

        $this->be($user);

        $this->get("talks/{$talk->id}/delete");

        $this->assertModelMissing($talk);
        $this->assertModelMissing($talkRevision);
    }

    /** @test */
    public function user_can_save_a_new_revision_of_a_talk()
    {
        $user = User::factory()->create();
        $talk = Talk::factory()->author($user)
            ->revised([
                'title' => 'old title',
                'created_at' => Carbon::now()->subMinutes(2),
            ])
            ->create([
                'public' => false,
            ]);

        $this->actingAs($user)
            ->put("/talks/{$talk->id}", array_merge($talk->loadCurrentRevision()->currentRevision->toArray(), [
                'title' => 'New',
                'public' => '1',
            ]));

        $talk = Talk::first();

        $this->assertTrue($talk->public);
        $this->assertEquals('New', $talk->loadCurrentRevision()->currentRevision->title);
        $this->assertEquals('old title', $talk->revisions->last()->title);
    }

    /** @test */
    function revised_talks_must_include_required_fields()
    {
        $user = User::factory()->create();
        $talk = Talk::factory()->author($user)->create();

        $response = $this->actingAs($user)->put("/talks/{$talk->id}", []);

        $response->assertInvalid([
            'title',
            'type',
            'level',
            'length',
            'organizer_notes',
            'description',
            'public',
        ]);
    }

    /** @test */
    function revised_talks_must_include_a_valid_length()
    {
        $user = User::factory()->create();
        $talk = Talk::factory()->author($user)->create();

        $response = $this->actingAs($user)
            ->put("/talks/{$talk->id}", array_merge($talk->loadCurrentRevision()->currentRevision->toArray(), [
                'length' => 'invalid',
            ]));

        $response->assertInvalid(['length']);
    }

    /** @test */
    function revised_talks_with_slides_must_include_a_valid_slides_url()
    {
        $user = User::factory()->create();
        $talk = Talk::factory()->author($user)->create();

        $response = $this->actingAs($user)
            ->put("/talks/{$talk->id}", array_merge($talk->loadCurrentRevision()->currentRevision->toArray(), [
                'slides' => 'invalid url',
            ]));

        $response->assertInvalid(['slides']);
    }

    /** @test */
    public function scoping_talks_where_submitted()
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
    public function scoping_talks_where_accepted()
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

    /** @test */
    function archived_talks_are_not_included_in_queries_by_default()
    {
        $talk = Talk::factory()->archived()->create();

        $activeTalks = Talk::all();
        $this->assertNotContains($talk->id, $activeTalks->pluck('id'));

        // talk is included when excluding query scope
        $allTalks = Talk::withoutGlobalScope('active')->get();
        $this->assertContains($talk->id, $allTalks->pluck('id'));
    }

    /** @test */
    function archived_talks_can_be_restored()
    {
        $talk = Talk::factory()->archived()->create();

        $response = $this->actingAs($talk->author)
            ->get(route('talks.restore', $talk));

        $response->assertRedirect('archive');
        $this->assertFalse($talk->fresh()->isArchived());
    }

    /** @test */
    function archived_talks_can_be_deleted()
    {
        $talk = Talk::factory()->archived()->create();

        $response = $this->actingAs($talk->author)
            ->delete(route('talks.destroy', $talk));

        $response->assertRedirect('talks');
        $this->assertDatabaseMissing('talks', ['id' => $talk->id]);
    }

    /** @test */
    public function editing_a_talk(): void
    {
        $talk = Talk::factory()->create();

        $response = $this->actingAs($talk->author)
            ->get(route('talks.edit', $talk));

        $response->assertSuccessful();
    }
}
