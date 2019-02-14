<?php

use App\Conference;
use App\Submission;
use App\Talk;
use App\TalkRevision;
use App\User;

class SubmissionTest extends IntegrationTestCase
{
    /** @test */
    function user_can_submit_talks_via_http()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $conference = factory(Conference::class)->create();
        $talk = factory(Talk::class)->create(['author_id' => $user->id]);
        $revision = factory(TalkRevision::class)->create();
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

        $this->delete('submissions/'.$submission->id);

        $this->assertTrue($conference->submissions->isEmpty());
    }

    /** @test */
    function user_cannot_submit_other_users_talk()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $otherUser = factory(User::class)->create([
            'email' => 'a@b.com',
        ]);

        $conference = factory(Conference::class)->create();
        $talk = factory(Talk::class)->create([
            'author_id' => $otherUser->id,
        ]);
        $revision = factory(TalkRevision::class)->create();
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
        $user = factory(User::class)->create();
        $this->be($user);
        $otherUser = factory(User::class)->create([
            'email' => 'a@b.com',
        ]);

        $conference = factory(Conference::class)->create();
        $talk = factory(Talk::class)->create([
            'author_id' => $otherUser->id,
        ]);
        $revision = factory(TalkRevision::class)->create([
            'talk_id' => $talk->id,
        ]);

        $submission = factory(Submission::class)->create([
            'talk_revision_id' => $revision->id,
            'conference_id' => $conference->id
        ]);

        $this->delete('submissions/'.$submission->id);

        $this->assertEquals(1, $conference->submissions->count());
        $this->assertTrue($conference->submissions->contains($submission));
    }
}
