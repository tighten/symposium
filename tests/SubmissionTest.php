<?php

use App\Commands\CreateSubmission;
use App\Commands\DestroySubmission;
use App\Conference;
use Illuminate\Support\Facades\Session;
use Laracasts\TestDummy\Factory;

class SubmissionTest extends IntegrationTestCase
{
    /** @test */
    function submitting_attaches_to_conference()
    {
        $user = Factory::create('user');
        $conference = Factory::create('conference');
        $talk = Factory::create('talk', [
            'author_id' => $user->id,
        ]);
        $revision = Factory::create('talkRevision');
        $talk->revisions()->save($revision);

        dispatch(new CreateSubmission($conference->id, $talk->id));

        $revision = $revision->fresh();

        $this->assertTrue($conference->submissions->contains($revision));
    }

    /** @test */
    function un_submitting_deletes_submission()
    {
        $user = Factory::create('user');
        $conference = Factory::create('conference');
        $talk = Factory::create('talk', [
            'author_id' => $user->id,
        ]);
        $revision = Factory::create('talkRevision');
        $talk->revisions()->save($revision);

        dispatch(new CreateSubmission($conference->id, $talk->id));

        dispatch(new DestroySubmission($conference->id, $talk->id));

        $revision = $revision->fresh();

        $this->assertFalse($conference->submissions->contains($revision));
    }

    /** @test */
    function un_submitting_deletes_only_this_conference_submission()
    {
        $user = Factory::create('user');

        $conference1 = Factory::create('conference');
        $conference2 = Factory::create('conference');

        $talk1 = Factory::create('talk', [
            'author_id' => $user->id,
        ]);
        $talk1revision = Factory::create('talkRevision');
        $talk1->revisions()->save($talk1revision);

        $talk2 = Factory::create('talk', [
            'author_id' => $user->id,
        ]);
        $talk2revision = Factory::create('talkRevision');
        $talk2->revisions()->save($talk2revision);

        $talk2revision = $talk2revision->fresh();

        dispatch(new CreateSubmission($conference1->id, $talk1->id));
        dispatch(new CreateSubmission($conference1->id, $talk2->id));
        dispatch(new DestroySubmission($conference1->id, $talk1->id));
        $this->assertTrue($conference1->submissions->contains($talk2revision));

        dispatch(new CreateSubmission($conference2->id, $talk2->id));
        dispatch(new CreateSubmission($conference2->id, $talk1->id));
        dispatch(new DestroySubmission($conference2->id, $talk1->id));
        $this->assertTrue($conference2->submissions->contains($talk2revision));
    }

    /** @test */
    function submits_current_revision_if_many()
    {
        $user = Factory::create('user');
        $conference = Factory::create('conference');
        $talk = Factory::create('talk', [
            'author_id' => $user->id,
        ]);

        $oldRevision = Factory::create('talkRevision', [
            'created_at' => '1999-01-01 01:01:01',
        ]);
        $talk->revisions()->save($oldRevision);

        $revision = Factory::create('talkRevision');
        $talk->revisions()->save($revision);

        dispatch(new CreateSubmission($conference->id, $talk->id));
        $conference->load('submissions');

        $revision = $revision->fresh();

        $this->assertTrue($conference->submissions->contains($revision));
    }

    /** @test */
    function un_submitting_one_revision_of_many_works()
    {
        $user = Factory::create('user');
        $conference = Factory::create('conference');
        $talk = Factory::create('talk', [
            'author_id' => $user->id,
        ]);

        $oldRevision = Factory::create('talkRevision', [
            'title' => 'oldie',
            'created_at' => '1999-01-01 01:01:01',
        ]);
        $talk->revisions()->save($oldRevision);

        $revision = Factory::create('talkRevision', [
            'title' => 'submitted i hope',
        ]);
        $talk->revisions()->save($revision);

        dispatch(new CreateSubmission($conference->id, $talk->id));

        $revision2 = Factory::create('talkRevision');
        $talk->revisions()->save($revision2);

        $revision = $revision->fresh();

        $this->assertTrue($conference->submissions->contains($revision));

        dispatch(new DestroySubmission($conference->id, $talk->id));
        $conference->load('submissions'); // reload

        $this->assertFalse($conference->submissions->contains($revision));
    }

    /** @test */
    function un_submitting_does_not_delete_conference()
    {
        $user = Factory::create('user');
        $conference = Factory::create('conference');
        $talk = Factory::create('talk', [
            'author_id' => $user->id,
        ]);
        $revision = Factory::create('talkRevision');
        $talk->revisions()->save($revision);

        dispatch(new CreateSubmission($conference->id, $talk->id));

        dispatch(new DestroySubmission($conference->id, $talk->id));

        $this->assertEquals(1, Conference::find($conference->id)->count());
    }

    /** @test */
    function user_can_submit_talks_via_http()
    {
        $user = Factory::create('user');
        $this->be($user);

        $conference = Factory::create('conference');
        $talk = Factory::create('talk', [
            'author_id' => $user->id,
        ]);
        $revision = Factory::create('talkRevision');
        $talk->revisions()->save($revision);

        $this->post('submissions', [
            'conferenceId' => $conference->id,
            'talkId' => $talk->id,
            '_token' => csrf_token(),
        ]);

        $revision = $revision->fresh();

        $this->assertTrue($conference->submissions->contains($revision));
    }

    /** @test */
    function user_cannot_submit_other_users_talk()
    {
        $user = Factory::create('user');
        $this->be($user);
        $otherUser = Factory::create('user', [
            'email' => 'a@b.com',
        ]);

        $conference = Factory::create('conference');
        $talk = Factory::create('talk', [
            'author_id' => $otherUser->id,
        ]);
        $revision = Factory::create('talkRevision');
        $talk->revisions()->save($revision);

        $this->post('submissions', [
            'conferenceId' => $conference->id,
            'talkId' => $talk->id,
            '_token' => Session::token(),
        ]);

        $revision = $revision->fresh();

        $this->assertEquals(0, $conference->submissions->count());
        $this->assertFalse($conference->submissions->contains($revision));
    }
}
