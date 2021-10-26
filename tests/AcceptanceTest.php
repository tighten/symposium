<?php

namespace Tests;

use App\Acceptance;
use App\Conference;
use App\Rejection;
use App\Submission;
use App\Talk;
use App\TalkRevision;
use App\User;

class AcceptanceTest extends IntegrationTestCase
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

        $acceptance = Acceptance::createFromSubmission($submission);

        $submission = $submission->refresh();

        $this->assertTrue($submission->isAccepted());
        $this->assertEquals($submission->id, $acceptance->submission->id);
    }

    /** @test */
    function user_can_mark_talks_as_accepted_via_http()
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

        $this->post('acceptances', [
            'submissionId' => $submission->id,
        ]);

        $this->assertTrue($submission->refresh()->isAccepted());
    }

    /** @test */
    function user_can_remove_acceptance_via_http()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $conference = factory(Conference::class)->create();
        $talk = factory(Talk::class)->create(['author_id' => $user->id]);
        $revision = factory(TalkRevision::class)->create();
        $talk->revisions()->save($revision);

        $acceptance = factory(Acceptance::class)->create();

        $submission = factory(Submission::class)->create([
            'talk_revision_id' => $revision->id,
            'conference_id' => $conference->id,
            'acceptance_id' => $acceptance->id,
        ]);

        $this->delete('acceptances/' . $acceptance->id);

        $this->assertFalse($submission->refresh()->isAccepted());
    }

    /** @test */
    function an_accepted_talk_cannot_be_rejected()
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

        $response = $this->post('acceptances', [
            'submissionId' => $submission->id,
        ]);

        $response->seeStatusCode(403);
        tap($submission->refresh(), function ($submission) {
            $this->assertFalse($submission->isAccepted());
            $this->assertTrue($submission->isRejected());
        });
    }
}
