<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\Rejection;
use App\Models\Submission;
use App\Models\Talk;
use App\Models\TalkRevision;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    #[Test]
    public function user_can_submit_talks_via_http(): void
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

    #[Test]
    public function user_can_unsubmit_talks_via_http(): void
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

    #[Test]
    public function user_cannot_submit_other_users_talk(): void
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

    #[Test]
    public function user_cannot_unsubmit_other_users_talk(): void
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

    #[Test]
    public function viewing_the_edit_form(): void
    {
        $user = User::factory()->create();
        $talk = Talk::factory()->author($user)->create();
        $conference = Conference::factory()
            ->received($talk->revisions()->first())
            ->create(['title' => 'JediCon']);

        $response = $this->actingAs($user)->get(route('submission.edit', $talk->submissions()->first()));

        $response->assertSuccessful();
        $response->assertSee('JediCon');
    }

    #[Test]
    public function user_can_add_a_reason_for_acceptance(): void
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

    #[Test]
    public function user_can_add_a_reason_for_rejection(): void
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

    #[Test]
    public function it_can_validate_the_response_type(): void
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

    #[Test]
    public function it_can_store_an_acceptance_without_a_reason(): void
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

    #[Test]
    public function acceptance_reasons_can_be_updated(): void
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

    #[Test]
    public function rejection_reasons_can_be_updated(): void
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

    #[Test]
    public function toggling_submission_responses_from_accepted_to_rejected(): void
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

    #[Test]
    public function toggling_submission_responses_from_rejected_to_accepted(): void
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

    #[Test]
    public function users_cannot_update_submissions_of_other_users(): void
    {
        $otherUser = User::factory()->create();
        $submission = Submission::factory()->rejected()->create();

        $response = $this->actingAs($otherUser)
            ->put(route('submission.update', $submission), [
                'response' => 'acceptance',
            ]);

        $response->assertStatus(401);
        tap($submission->fresh(), function ($submission) {
            $this->assertFalse($submission->isAccepted());
            $this->assertTrue($submission->isRejected());
        });
        $this->assertDatabaseHas('rejections', [
            'talk_revision_id' => $submission->talk_revision_id,
        ]);
        $this->assertDatabaseMissing('acceptances', [
            'talk_revision_id' => $submission->talk_revision_id,
        ]);
    }

    #[Test]
    public function submissions_with_an_acceptance_have_an_acceptance_response_and_reason(): void
    {
        $submission = Submission::factory()->accepted([
            'reason' => 'it was a good talk',
        ])->create();

        $this->assertEquals('acceptance', $submission->response);
        $this->assertEquals('it was a good talk', $submission->response_reason);
    }

    #[Test]
    public function submissions_with_a_rejection_have_a_rejection_response(): void
    {
        $submission = Submission::factory()->rejected([
            'reason' => 'it was a bad talk',
        ])->create();

        $this->assertEquals('rejection', $submission->response);
        $this->assertEquals('it was a bad talk', $submission->response_reason);
    }

    #[Test]
    public function scoping_submissions_where_not_rejected(): void
    {
        $submissionA = Submission::factory()->pending()->create();
        $submissionB = Submission::factory()->accepted()->create();
        $submissionC = Submission::factory()->rejected()->create();

        $submissionIds = Submission::whereNotRejected()->get()->pluck('id');

        $this->assertContains($submissionA->id, $submissionIds);
        $this->assertContains($submissionB->id, $submissionIds);
        $this->assertNotContains($submissionC->id, $submissionIds);
    }

    #[Test]
    public function scoping_sumissions_where_future(): void
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
