<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laracasts\TestDummy\Factory;
use Symposium\Exceptions\ValidationException;
use Symposium\Services\CreateConferenceForm;

class PublicSpeakerProfileTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    public function test_it_does_not_show_a_profile_for_non_public_speakers()
    {
        $user = Factory::create('user', [
            'profile_slug' => 'mattstauffer',
            'enable_profile' => false
        ]);

        $this->get(route('speakers-public.show', [$user->profile_slug]));
        $this->assertResponseStatus(404);
    }

    public function test_it_shows_a_profile_for_public_speakers()
    {
        $user = Factory::create('user', [
            'profile_slug' => 'abrahamlincoln',
            'enable_profile' => true
        ]);

        $this->visit(route('speakers-public.show', [$user->profile_slug]));
        $this->see($user->name);
    }

    public function test_it_does_not_list_talks_marked_not_public()
    {
        $user = Factory::create('user', [
            'profile_slug' => 'tonimorrison',
            'enable_profile' => true
        ]);

        $talk = Factory::build('talk');
        $talk->public = false;
        $user->talks()->save($talk);
        $talkRevision = Factory::build('talkRevision');
        $talk->revisions()->save($talkRevision);

        $this->get(route('speakers-public.show', [$user->profile_slug]));
        $this->assertResponseOk();
        $this->dontSee($talkRevision->title);
    }

    public function test_it_does_not_show_talks_marked_not_public()
    {
        $user = Factory::create('user', [
            'profile_slug' => 'jamesandthegiantpeach',
            'enable_profile' => true
        ]);

        $talk = Factory::build('talk');
        $talk->public = false;
        $user->talks()->save($talk);
        $talkRevision = Factory::build('talkRevision');
        $talk->revisions()->save($talkRevision);

        $this->get(route('speakers-public.talks.show', [$user->profile_slug]));
        $this->assertResponseStatus(404);
    }

    public function test_it_shows_talks_marked_public()
    {
        $user = Factory::create('user', [
            'profile_slug' => 'zipporah',
            'enable_profile' => true
        ]);

        $talk = Factory::build('talk');
        $talk->public = true;
        $user->talks()->save($talk);
        $talkRevision = Factory::build('talkRevision');
        $talk->revisions()->save($talkRevision);

        $this->get(route('speakers-public.show', [$user->profile_slug]));
        $this->assertResponseOk();
        $this->see($talkRevision->title);
    }

    public function test_it_does_not_show_bios_marked_not_public()
    {
        $user = Factory::create('user', [
            'profile_slug' => 'kuntakinte',
            'enable_profile' => true
        ]);

        $bio = Factory::build('bio');
        $bio->public = false;
        $user->bios()->save($bio);

        $this->visit(route('speakers-public.show', [$user->profile_slug]));
        $this->dontSee($bio->nickname);
    }

    public function test_it_shows_bios_marked_public()
    {
        $user = Factory::create('user', [
            'profile_slug' => 'mydearauntsally',
            'enable_profile' => true
        ]);

        $bio = Factory::build('bio');
        $bio->public = true;
        $user->bios()->save($bio);

        $this->visit(route('speakers-public.show', [$user->profile_slug]));
        $this->see($bio->nickname);
    }

    public function test_public_profile_page_is_off_by_default()
    {
        $user = Factory::create('user', [
            'profile_slug' => 'jimmybob',
        ]);

        $this->get(route('speakers-public.show', [$user->profile_slug]));
        $this->assertResponseStatus(404);
    }
}
