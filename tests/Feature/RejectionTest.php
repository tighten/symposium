<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\Rejection;
use App\Models\Submission;
use App\Models\Talk;
use App\Models\TalkRevision;
use App\Models\User;
use Tests\TestCase;

class RejectionTest extends TestCase
{
    /** @test */
    function can_create_from_submission()
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

        $rejection = Rejection::createFromSubmission($submission);

        $submission = $submission->refresh();

        $this->assertTrue($submission->isRejected());
        $this->assertEquals($submission->id, $rejection->submission->id);
    }

    /** @test */
    function user_can_remove_rejection_via_http()
    {
        $user = User::factory()->create();
        $this->be($user);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->author($user)->create();
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
