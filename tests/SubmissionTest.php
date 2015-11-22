<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use Laracasts\TestDummy\Factory;
use Symposium\Commands\CreateSubmission;
use Symposium\Commands\DestroySubmission;

class SubmissionTest extends IntegrationTestCase
{
    /** @test */
    public function submitting_attaches_to_conference()
    {
        $user = Factory::create('user');
        $conference = Factory::create('conference');
        $talk = Factory::create('talk', [
            'author_id' => $user->id
        ]);
        $revision = Factory::create('talkRevision');
        $talk->revisions()->save($revision);

        Bus::dispatch(new CreateSubmission($conference->id, $revision->id));

        $this->assertTrue($conference->submissions->contains($revision));
    }

    /** @test */
    public function un_submitting_deletes_submission()
    {
        $user = Factory::create('user');
        $conference = Factory::create('conference');
        $talk = Factory::create('talk', [
            'author_id' => $user->id
        ]);
        $revision = Factory::create('talkRevision');
        $talk->revisions()->save($revision);

        Bus::dispatch(new CreateSubmission($conference->id, $revision->id));

        Bus::dispatch(new DestroySubmission($conference->id, $revision->id));

        $this->assertFalse($conference->submissions->contains($revision));
    }

    /** @test */
    public function un_submitting_does_not_delete_conference()
    {
        $user = Factory::create('user');
        $conference = Factory::create('conference');
        $talk = Factory::create('talk', [
            'author_id' => $user->id
        ]);
        $revision = Factory::create('talkRevision');
        $talk->revisions()->save($revision);

        Bus::dispatch(new CreateSubmission($conference->id, $revision->id));

        Bus::dispatch(new DestroySubmission($conference->id, $revision->id));

        $this->assertEquals(1, Conference::find($conference->id)->count());
    }
}
