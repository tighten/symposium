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
    public function user_can_submit_talks_via_http()
    {
        $user = User::factory()->create();
        $this->be($user);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->author($user)->create();
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);

        $this->post('submissions', [
            'conferenceId' => $conference->id,
            'talkId' => $talk->id,
        ]);

        $this->assertTrue($conference->submissions->count() === 1);
    }

    /** @test */
    public function user_can_unsubmit_talks_via_http()
    {
        $user = User::factory()->create();
        $this->be($user);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->author($user)->create();
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);

        $submission = Submission::factory()->create([
            'talk_revision_id' => $revision->id,
            'conference_id' => $conference->id,
        ]);

        $this->delete("submissions/{$submission->id}");

        $this->assertModelMissing($submission);
        $this->assertTrue($conference->submissions->isEmpty());
    }

    /** @test */
    public function user_cannot_submit_other_users_talk()
    {
        $user = User::factory()->create();
        $this->be($user);
        $otherUser = User::factory()->create([
            'email' => 'a@b.com',
        ]);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->author($otherUser)->create();
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);

        $this->post('submissions', [
            'conferenceId' => $conference->id,
            'talkId' => $talk->id,
        ]);

        $this->assertEquals(0, $conference->submissions->count());
    }

    /** @test */
    public function user_cannot_unsubmit_other_users_talk()
    {
        $user = User::factory()->create();
        $this->be($user);
        $otherUser = User::factory()->create([
            'email' => 'a@b.com',
        ]);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->author($otherUser)->create();
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
        $talk = Talk::factory()->author($user)->create();
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
        $talk = Talk::factory()->author($user)->create();
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
        $talk = Talk::factory()->author($user)->create();
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
        $talk = Talk::factory()->author($user)->create();
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

    /** @test */
    function acceptance_reasons_can_be_updated()
    {
        $submission = Submission::factory()->accepted([
            'reason' => 'great talk',
        ])->create();

        $response = $this->actingAs($submission->author())
            ->put(route('submission.update', $submission), [
                'response' => 'acceptance',
                'reason' => 'awesome talk',
            ]);

        $response->assertRedirect();
        tap($submission->fresh(), function ($submission) {
            $this->assertTrue($submission->isAccepted());
            $this->assertEquals('awesome talk', $submission->acceptance->reason);
        });
    }

    /** @test */
    function rejection_reasons_can_be_updated()
    {
        $submission = Submission::factory()->rejected([
            'reason' => 'bad talk',
        ])->create();

        $response = $this->actingAs($submission->author())
            ->put(route('submission.update', $submission), [
                'response' => 'acceptance',
                'reason' => 'terrible talk',
            ]);

        $response->assertRedirect();
        tap($submission->fresh(), function ($submission) {
            $this->assertTrue($submission->isAccepted());
            $this->assertEquals('terrible talk', $submission->acceptance->reason);
        });
    }

    /** @test */
    function toggling_submission_responses_from_accepted_to_rejected()
    {
        $submission = Submission::factory()->accepted()->create();

        $response = $this->actingAs($submission->author())
            ->put(route('submission.update', $submission), [
                'response' => 'rejection',
            ]);

        $response->assertRedirect();
        tap($submission->fresh(), function ($submission) {
            $this->assertTrue($submission->isRejected());
            $this->assertFalse($submission->isAccepted());
        });
        $this->assertDatabaseMissing('acceptances', [
            'talk_revision_id' => $submission->talk_revision_id,
        ]);
    }

    /** @test */
    function toggling_submission_responses_from_rejected_to_accepted()
    {
        $submission = Submission::factory()->rejected()->create();

        $response = $this->actingAs($submission->author())
            ->put(route('submission.update', $submission), [
                'response' => 'acceptance',
            ]);

        $response->assertRedirect();
        tap($submission->fresh(), function ($submission) {
            $this->assertTrue($submission->isAccepted());
            $this->assertFalse($submission->isRejected());
        });
        $this->assertDatabaseMissing('rejections', [
            'talk_revision_id' => $submission->talk_revision_id,
        ]);
    }

    /** @test */
    function submissions_with_an_acceptance_have_an_acceptance_response_and_reason()
    {
        $submission = Submission::factory()->accepted([
            'reason' => 'it was a good talk',
        ])->create();

        $this->assertEquals('acceptance', $submission->response);
        $this->assertEquals('it was a good talk', $submission->response_reason);
    }

    /** @test */
    function submissions_with_a_rejection_have_a_rejection_response()
    {
        $submission = Submission::factory()->rejected([
            'reason' => 'it was a bad talk',
        ])->create();

        $this->assertEquals('rejection', $submission->response);
        $this->assertEquals('it was a bad talk', $submission->response_reason);
    }

    /** @test */
    function scoping_submissions_where_not_rejected()
    {
        $submissionA = Submission::factory()->pending()->create();
        $submissionB = Submission::factory()->accepted()->create();
        $submissionC = Submission::factory()->rejected()->create();

        $submissionIds = Submission::whereNotRejected()->get()->pluck('id');

        $this->assertContains($submissionA->id, $submissionIds);
        $this->assertContains($submissionB->id, $submissionIds);
        $this->assertNotContains($submissionC->id, $submissionIds);
    }

    /** @test */
    function scoping_sumissions_where_future()
    {
        $submissionA = Submission::factory()
            ->forConference(['starts_at' => now()->addDay()])
            ->create();
        $submissionB = Submission::factory()
            ->forConference(['starts_at' => now()->subDay()])
            ->create();

        $submissionIds = Submission::whereFuture()->get()->pluck('id');

        $this->assertContains($submissionA->id, $submissionIds);
        $this->assertNotContains($submissionB->id, $submissionIds);
    }
}
