<?php

namespace Tests;

use App\Conference;
use App\Rejection;
use App\Submission;
use App\Talk;
use App\TalkRevision;
use App\User;

class RejectionTest extends IntegrationTestCase
{
    /** @test */
    function can_create_from_submission()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $conference = factory(Conference::class)->create();
        $talk = factory(Talk::class)->create(['author_id' => $user->id]);
        $revision = factory(TalkRevision::class)->create();
        $talk->revisions()->save($revision);

        $submission = factory(Submission::class)->create([
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
        $user = factory(User::class)->create();
        $this->be($user);

        $conference = factory(Conference::class)->create();
        $talk = factory(Talk::class)->create(['author_id' => $user->id]);
        $revision = factory(TalkRevision::class)->create();
        $talk->revisions()->save($revision);
        $submission = factory(Submission::class)->create([
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
        $user = factory(User::class)->create();
        $this->be($user);

        $conference = factory(Conference::class)->create();
        $talk = factory(Talk::class)->create(['author_id' => $user->id]);
        $revision = factory(TalkRevision::class)->create();
        $talk->revisions()->save($revision);

        $rejection = factory(Rejection::class)->create();

        $submission = factory(Submission::class)->create([
            'talk_revision_id' => $revision->id,
            'conference_id' => $conference->id,
            'rejection_id' => $rejection->id,
        ]);

        $this->delete('rejections/' . $rejection->id);

        $this->assertFalse($submission->refresh()->isRejected());
    }
}
