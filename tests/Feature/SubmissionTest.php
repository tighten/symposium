<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\Rejection;
use App\Models\Submission;
use App\Models\Talk;
use App\Models\TalkRevision;
use App\Models\User;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    /** @test */
    function user_can_submit_talks_via_http()
    {
        $user = User::factory()->create();
        $this->be($user);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->create(['author_id' => $user->id]);
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);

        $this->post('submissions', [
            'conferenceId' => $conference->id,
            'talkId' => $talk->id,
        ]);

        $this->assertTrue($conference->submissions->count() === 1);
    }

    /** @test */
    function user_can_unsubmit_talks_via_http()
    {
        $user = User::factory()->create();
        $this->be($user);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->create(['author_id' => $user->id]);
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);

        $submission = Submission::factory()->create([
            'talk_revision_id' => $revision->id,
            'conference_id' => $conference->id,
        ]);

        $this->delete("submissions/{$submission->id}");

        $this->assertDeleted($submission);
        $this->assertTrue($conference->submissions->isEmpty());
    }

    /** @test */
    function user_cannot_submit_other_users_talk()
    {
        $user = User::factory()->create();
        $this->be($user);
        $otherUser = User::factory()->create([
            'email' => 'a@b.com',
        ]);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->create([
            'author_id' => $otherUser->id,
        ]);
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);

        $this->post('submissions', [
            'conferenceId' => $conference->id,
            'talkId' => $talk->id,
        ]);

        $this->assertEquals(0, $conference->submissions->count());
    }

    /** @test */
    function user_cannot_unsubmit_other_users_talk()
    {
        $user = User::factory()->create();
        $this->be($user);
        $otherUser = User::factory()->create([
            'email' => 'a@b.com',
        ]);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->create([
            'author_id' => $otherUser->id,
        ]);
        $revision = TalkRevision::factory()->create([
            'talk_id' => $talk->id,
        ]);

        $submission = Submission::factory()->create([
            'talk_revision_id' => $revision->id,
            'conference_id' => $conference->id,
        ]);

        $this->delete("submissions/{$submission->id}");

        $this->assertModelExists($submission);
        $this->assertEquals(1, $conference->submissions->count());
        $this->assertTrue($conference->submissions->contains($submission));
    }

    /** @test */
    public function user_can_add_a_reason_for_acceptance()
    {
        $user = User::factory()->create();
        $this->be($user);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->create(['author_id' => $user->id]);
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);
        $submission = Submission::factory()->create([
            'conference_id' => $conference->id,
            'talk_revision_id' => $revision->id,
        ]);

        $this->put(route('submission.update', $submission), [
            'response' => 'acceptance',
            'reason' => 'Looking forward to this talk on Dogs!',
        ]);

        $this->assertSame(
            'Looking forward to this talk on Dogs!',
            $submission->refresh()->acceptance->reason,
        );
    }

    /** @test */
    public function user_can_add_a_reason_for_rejection()
    {
        $user = User::factory()->create();
        $this->be($user);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->create(['author_id' => $user->id]);
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);
        $submission = Submission::factory()->create([
            'conference_id' => $conference->id,
            'talk_revision_id' => $revision->id,
        ]);

        $this->put(route('submission.update', $submission), [
            'response' => 'rejection',
            'reason' => 'Dogs is not the topic of this conference.',
        ]);

        $this->assertSame(
            'Dogs is not the topic of this conference.',
            $submission->refresh()->rejection->reason,
        );
    }

    /** @test */
    public function it_can_validate_the_response_type()
    {
        $user = User::factory()->create();
        $this->be($user);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->create(['author_id' => $user->id]);
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);
        $submission = Submission::factory()->create([
            'conference_id' => $conference->id,
            'talk_revision_id' => $revision->id,
        ]);

        $this->put(route('submission.update', $submission), [
            'response' => 'indifference',
        ])->assertSessionHasErrors();
    }

    /** @test */
    public function it_can_store_an_acceptance_without_a_reason()
    {
        $user = User::factory()->create();
        $this->be($user);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->create(['author_id' => $user->id]);
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);
        $submission = Submission::factory()->create([
            'conference_id' => $conference->id,
            'talk_revision_id' => $revision->id,
        ]);

        $this->put(route('submission.update', $submission), [
            'response' => 'rejection',
        ])->assertSessionHas('success-message', 'Successfully updated submission.');

        $rejection = Rejection::where('talk_revision_id', $revision->id)->first();
        $this->assertSame($submission->talk_revision_id, $rejection->talk_revision_id);
    }
}
