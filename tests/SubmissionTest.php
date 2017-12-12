<?php

use App\Conference;
use App\Commands\CreateSubmission;
use App\Commands\DestroySubmission;
use Illuminate\Support\Facades\Session;

class SubmissionTest extends IntegrationTestCase
{
    /** @test */
    function submitting_attaches_to_conference()
    {
        $user = factory(App\User::class)->create();
        $conference = factory(App\Conference::class)->create();
        $talk = factory(App\Talk::class)->create(['author_id' => $user->id]);
        $revision = factory(App\TalkRevision::class)->create();
        $talk->revisions()->save($revision);

        dispatch(new CreateSubmission($conference->id, $talk->id));

        $revision = $revision->fresh();

        $this->assertTrue($conference->submissions->contains($revision));
    }

    /** @test */
    function un_submitting_deletes_submission()
    {
        $user = factory(App\User::class)->create();
        $conference = factory(App\Conference::class)->create();
        $talk = factory(App\Talk::class)->create(['author_id' => $user->id]);
        $revision = factory(App\TalkRevision::class)->create();
        $talk->revisions()->save($revision);

        dispatch(new CreateSubmission($conference->id, $talk->id));
        dispatch(new DestroySubmission($conference->id, $talk->id));

        $revision = $revision->fresh();

        $this->assertFalse($conference->submissions->contains($revision));
    }

    /** @test */
    function un_submitting_deletes_only_this_conference_submission()
    {
        $user = factory(App\User::class)->create();

        $conference1 = factory(App\Conference::class)->create();
        $conference2 = factory(App\Conference::class)->create();

        $talk1 = factory(App\Talk::class)->create(['author_id' => $user->id]);
        $talk1Revision = factory(App\TalkRevision::class)->create();
        $talk1->revisions()->save($talk1Revision);

        $talk2 = factory(App\Talk::class)->create(['author_id' => $user->id]);
        $talk2Revision = factory(App\TalkRevision::class)->create();
        $talk2->revisions()->save($talk2Revision);

        $talk2Revision = $talk2Revision->fresh();

        dispatch(new CreateSubmission($conference1->id, $talk1->id));
        dispatch(new CreateSubmission($conference1->id, $talk2->id));
        dispatch(new DestroySubmission($conference1->id, $talk1->id));
        $this->assertTrue($conference1->submissions->contains($talk2Revision));

        dispatch(new CreateSubmission($conference2->id, $talk2->id));
        dispatch(new CreateSubmission($conference2->id, $talk1->id));
        dispatch(new DestroySubmission($conference2->id, $talk1->id));
        $this->assertTrue($conference2->submissions->contains($talk2Revision));
    }

    /** @test */
    function submits_current_revision_if_many()
    {
        $user = factory(App\User::class)->create();
        $conference = factory(App\Conference::class)->create();
        $talk = factory(App\Talk::class)->create(['author_id' => $user->id]);

        $oldRevision = factory(App\TalkRevision::class)->create(['created_at' => '1999-01-01 01:01:01']);
        $talk->revisions()->save($oldRevision);

        $revision = factory(App\TalkRevision::class)->create();
        $talk->revisions()->save($revision);

        dispatch(new CreateSubmission($conference->id, $talk->id));
        $conference->load('submissions');

        $revision = $revision->fresh();

        $this->assertTrue($conference->submissions->contains($revision));
    }

    /** @test */
    function un_submitting_one_revision_of_many_works()
    {
        $user = factory(App\User::class)->create();
        $conference = $user = factory(App\Conference::class)->create();
        $talk = factory(App\Talk::class)->create(['author_id' => $user->id]);

        $oldRevision = factory(App\TalkRevision::class)->create([
            'title' => 'oldie',
            'created_at' => '1999-01-01 01:01:01',
        ]);
        $talk->revisions()->save($oldRevision);

        $revision = factory(App\TalkRevision::class)->create(['title' => 'submitted i hope']);
        $talk->revisions()->save($revision);

        dispatch(new CreateSubmission($conference->id, $talk->id));

        $revision2 = factory(App\TalkRevision::class)->create();
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
        $user = factory(App\User::class)->create();
        $conference = factory(App\Conference::class)->create();
        $talk = factory(App\Talk::class)->create(['author_id' => $user->id]);
        $revision = factory(App\TalkRevision::class)->create();
        $talk->revisions()->save($revision);

        dispatch(new CreateSubmission($conference->id, $talk->id));
        dispatch(new DestroySubmission($conference->id, $talk->id));

        $this->assertEquals(1, Conference::find($conference->id)->count());
    }

    /** @test */
    function user_can_submit_talks_via_http()
    {
        $user = factory(App\User::class)->create();
        $this->be($user);

        $conference = factory(App\Conference::class)->create();
        $talk = factory(App\Talk::class)->create(['author_id' => $user->id]);
        $revision = factory(App\TalkRevision::class)->create();
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
        $user = factory(App\User::class)->create();
        $this->be($user);
        $otherUser = factory(App\User::class)->create([
            'email' => 'a@b.com',
        ]);

        $conference = factory(App\Conference::class)->create();
        $talk = factory(App\Talk::class)->create([
            'author_id' => $otherUser->id,
        ]);
        $revision = factory(App\TalkRevision::class)->create();
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
