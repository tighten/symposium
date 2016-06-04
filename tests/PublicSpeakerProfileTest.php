<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laracasts\TestDummy\Factory;
use App\Exceptions\ValidationException;
use App\Services\CreateConferenceForm;

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

        $this->get(route('speakers-public.talks.show', [$user->profile_slug, $talk->id]));
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

    public function test_it_does_not_show_contact_for_non_contactable_users()
    {
        $user = Factory::create('user', [
            'profile_slug' => 'jimmybob',
            'enable_profile' => true,
            'allow_profile_contact' => false,
        ]);

        $this
            ->visit(route('speakers-public.show', [$user->profile_slug]))
            ->dontSee('Contact ' . $user->name);

        $this
            ->get(route('speakers-public.email', [$user->profile_slug]))
            ->assertResponseStatus(404);

        $this
            ->post(route('speakers-public.email', [$user->profile_slug]))
            ->assertResponseStatus(404);
    }

    public function test_it_shows_contact_for_contactable_users()
    {
        $user = Factory::create('user', [
            'profile_slug' => 'jimmybob',
            'enable_profile' => true,
            'allow_profile_contact' => true,
        ]);

        $this
            ->visit(route('speakers-public.show', [$user->profile_slug]))
            ->see('Contact ' . $user->name);

        $this
            ->visit(route('speakers-public.email', [$user->profile_slug]))
            ->assertResponseOk();

        $this
            ->post(route('speakers-public.email', [$user->profile_slug]))
            ->followRedirects()
            ->assertResponseOk();
    }

    public function test_disabled_profile_user_cannot_be_contacted()
    {
        $user = Factory::create('user', [
            'profile_slug' => 'alphabetsoup',
            'enable_profile' => false,
            'allow_profile_contact' => true,
        ]);

        $this
            ->get(route('speakers-public.email', [$user->profile_slug]))
            ->assertResponseStatus(404);

        $this
            ->post(route('speakers-public.email', [$user->profile_slug]))
            ->assertResponseStatus(404);
    }

    public function test_it_does_not_show_talks_for_another_user()
    {
        $user = Factory::create('user', [
            'profile_slug' => 'jinkerjanker',
            'email' => 'a@b.com',
            'enable_profile' => true
        ]);

        $user2 = Factory::create('user', [
            'profile_slug' => 'alcatraz',
            'email' => 'c@d.com',
            'enable_profile' => true
        ]);

        $talk = Factory::build('talk');
        $talk->public = true;
        $user2->talks()->save($talk);
        $talkRevision = Factory::build('talkRevision');
        $talk->revisions()->save($talkRevision);

        $this
            ->visit(route('speakers-public.show', [$user->profile_slug]))
            ->dontSee($talk->current()->title);
    }

    public function test_it_does_not_show_bios_for_another_user()
    {
        $user = Factory::create('user', [
            'profile_slug' => 'stampede',
            'email' => 'a@b.com',
            'enable_profile' => true
        ]);

        $user2 = Factory::create('user', [
            'profile_slug' => 'cruising',
            'email' => 'c@d.com',
            'enable_profile' => true
        ]);

        $bio = Factory::build('bio');
        $bio->public = true;
        $user2->bios()->save($bio);

        $this
            ->visit(route('speakers-public.show', [$user->profile_slug]))
            ->dontSee($bio->nickname);
    }
}
