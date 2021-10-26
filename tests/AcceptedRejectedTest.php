<?php

namespace Tests;

use App\Acceptance;
use App\Conference;
use App\Rejection;
use App\Submission;
use App\Talk;
use App\TalkRevision;
use App\User;

class AcceptedRejectedTest extends IntegrationTestCase
{
    /** @test */
    public function an_accepted_submission_cannot_be_rejected()
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

        $acceptance = Acceptance::createFromSubmission($submission);

        $submission = $submission->refresh();

        $this->assertTrue($submission->isAccepted());
        $this->assertEquals($submission->id, $acceptance->submission->id);

        $this->post('rejections', [
            'submissionId' => $submission->id,
        ])->assertResponseStatus(403);

        $this->assertFalse($submission->refresh()->isRejected());
    }

    /** @test */
    public function a_rejected_submission_cannot_be_accepted()
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

        $this->post('acceptances', [
            'submissionId' => $submission->id,
        ])->assertResponseStatus(403);

        $this->assertFalse($submission->refresh()->isAccepted());
    }
}
