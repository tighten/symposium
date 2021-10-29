<?php

namespace Tests\Feature;

use App\Conference;
use App\Rejection;
use App\Submission;
use App\Talk;
use App\TalkRevision;
use App\User;
use Tests\IntegrationTestCase;

class RejectionTest extends IntegrationTestCase
{
    /** @test */
    function can_create_from_submission()
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

        $rejection = Rejection::createFromSubmission($submission);

        $submission = $submission->refresh();

        $this->assertTrue($submission->isRejected());
        $this->assertEquals($submission->id, $rejection->submission->id);
    }

    /** @test */
    function user_can_mark_talks_as_rejected_via_http()
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

        $this->post('rejections', [
            'submissionId' => $submission->id,
        ]);

        $this->assertTrue($submission->refresh()->isRejected());
    }

    /** @test */
    function user_can_remove_rejection_via_http()
    {
        $user = User::factory()->create();
        $this->be($user);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->create(['author_id' => $user->id]);
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);

        $rejection = Rejection::factory()->create();

        $submission = Submission::factory()->create([
            'talk_revision_id' => $revision->id,
            'conference_id' => $conference->id,
            'rejection_id' => $rejection->id,
        ]);

        $this->delete("rejections/{$rejection->id}");

        $this->assertFalse($submission->refresh()->isRejected());
    }
}
