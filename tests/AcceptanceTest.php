<?php

namespace Tests;

use App\Acceptance;
use App\Conference;
use App\Submission;
use App\Talk;
use App\TalkRevision;
use App\User;

class AcceptanceTest extends IntegrationTestCase
{
    /** @test */
    public function can_create_from_submission()
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

        $acceptance = Acceptance::createFromSubmission($submission);

        $submission = $submission->refresh();

        $this->assertTrue($submission->isAccepted());
        $this->assertEquals($submission->id, $acceptance->submission->id);
    }

    /** @test */
    public function user_can_mark_talks_as_accepted_via_http()
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

        $this->post('acceptances', [
            'submissionId' => $submission->id,
        ]);

        $this->assertTrue($submission->refresh()->isAccepted());
    }

    /** @test */
    public function user_can_remove_acceptance_via_http()
    {
        $user = User::factory()->create();
        $this->be($user);

        $conference = Conference::factory()->create();
        $talk = Talk::factory()->create(['author_id' => $user->id]);
        $revision = TalkRevision::factory()->create();
        $talk->revisions()->save($revision);

        $acceptance = Acceptance::factory()->create();

        $submission = Submission::factory()->create([
            'talk_revision_id' => $revision->id,
            'conference_id' => $conference->id,
            'acceptance_id' => $acceptance->id,
        ]);

        $this->delete('acceptances/'.$acceptance->id);

        $this->assertFalse($submission->refresh()->isAccepted());
    }
}
