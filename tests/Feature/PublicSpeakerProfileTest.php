<?php

namespace Tests\Feature;

use App\Mail\ContactRequest;
use App\Models\Bio;
use App\Models\Talk;
use App\Models\TalkRevision;
use App\Models\User;
use App\Services\FakeCaptcha;
use Captcha\Captcha;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\IntegrationTestCase;

class PublicSpeakerProfileTest extends IntegrationTestCase
{
    use RefreshDatabase;

    /** @test */
    function non_public_speakers_are_not_listed_on_the_public_speaker_page()
    {
        $user = User::factory()->create([
            'enable_profile' => false,
        ]);

        $this->visit(route('speakers-public.index'))
            ->dontSee($user->name);
    }

    /** @test */
    function public_speakers_are_listed_on_the_public_speaker_page()
    {
        $user = User::factory()->create([
            'profile_slug' => 'mattstauffer',
            'enable_profile' => true,
        ]);

        $this->visit(route('speakers-public.index'))
            ->see($user->name);
    }

    /** @test */
    function non_public_speakers_do_not_have_public_speaker_profile_pages()
    {
        $user = User::factory()->create([
            'profile_slug' => 'mattstauffer',
            'enable_profile' => false,
        ]);

        $this->get(route('speakers-public.show', [$user->profile_slug]));
        $this->assertResponseStatus(404);
    }

    /** @test */
    function public_speakers_have_public_speaker_profile_pages()
    {
        $user = User::factory()->create([
            'profile_slug' => 'abrahamlincoln',
            'enable_profile' => true,
        ]);

        $this->visit(route('speakers-public.show', [$user->profile_slug]))
            ->see($user->name);
    }

    /** @test */
    function talks_marked_not_public_are_not_listed_publicly()
    {
        $user = User::factory()->create([
            'profile_slug' => 'tonimorrison',
            'enable_profile' => true,
        ]);

        $talk = Talk::factory()->create();
        $talk->public = false;
        $user->talks()->save($talk);
        $talkRevision = TalkRevision::factory()->create();
        $talk->revisions()->save($talkRevision);

        $this->get(route('speakers-public.show', [$user->profile_slug]));
        $this->assertResponseOk();
        $this->dontSee($talkRevision->title);
    }

    /** @test */
    function talks_marked_not_public_do_not_have_public_pages()
    {
        $user = User::factory()->create([
            'profile_slug' => 'jamesandthegiantpeach',
            'enable_profile' => true,
        ]);

        $talk = Talk::factory()->create();
        $talk->public = false;
        $user->talks()->save($talk);
        $talkRevision = TalkRevision::factory()->create();
        $talk->revisions()->save($talkRevision);

        $this->get(route('speakers-public.talks.show', [$user->profile_slug, $talk->id]));
        $this->assertResponseStatus(404);
    }

    /** @test */
    function talks_marked_public_are_listed_publicly()
    {
        $user = User::factory()->create([
            'profile_slug' => 'zipporah',
            'enable_profile' => true,
        ]);

        $talk = Talk::factory()->create();
        $talk->public = true;
        $user->talks()->save($talk);
        $talkRevision = TalkRevision::factory()->create();
        $talk->revisions()->save($talkRevision);

        $this->get(route('speakers-public.show', [$user->profile_slug]));
        $this->assertResponseOk();
        $this->see($talkRevision->title);
    }

    /** @test */
    function bios_marked_public_are_listed_publicly()
    {
        $user = User::factory()->create([
            'profile_slug' => 'esther',
            'enable_profile' => true,
        ]);

        $bio = Bio::factory()->create();
        $bio->public = false;
        $user->bios()->save($bio);

        $this->get(route('speakers-public.show', [$user->profile_slug]));
        $this->assertResponseOk();
        $this->see($bio->title);
    }

    /** @test */
    function bios_marked_not_public_do_not_have_public_pages()
    {
        $user = User::factory()->create([
            'profile_slug' => 'kuntakinte',
            'enable_profile' => true,
        ]);

        $bio = Bio::factory()->create([
            'user_id' => $user->id,
            'nickname' => 'Private Bio',
            'public' => false,
        ]);

        $this->visit(route('speakers-public.show', [$user->profile_slug]));
        $this->dontSee('Private Bio');
    }

    /** @test */
    function bios_marked_public_have_public_pages()
    {
        $user = User::factory()->create([
            'profile_slug' => 'mydearauntsally',
            'enable_profile' => true,
        ]);

        $bio = Bio::factory()->create();
        $bio->public = true;
        $user->bios()->save($bio);

        $this->visit(route('speakers-public.show', [$user->profile_slug]));
        $this->see($bio->nickname);
    }

    /** @test */
    function public_profile_page_is_off_by_default()
    {
        $user = User::factory()->create([
            'profile_slug' => 'jimmybob',
        ]);

        $this->get(route('speakers-public.show', [$user->profile_slug]));
        $this->assertResponseStatus(404);
    }

    /** @test */
    function non_contactable_users_profile_pages_do_not_show_contact()
    {
        $this->withoutMiddleware();

        $user = User::factory()->create([
            'profile_slug' => 'jimmybob',
            'enable_profile' => true,
            'allow_profile_contact' => false,
        ]);

        $this->visit(route('speakers-public.show', [$user->profile_slug]))
            ->dontSee("Contact {$user->name}");

        $this->get(route('speakers-public.email', [$user->profile_slug]))
            ->assertResponseStatus(404);

        $this->post(route('speakers-public.email', [$user->profile_slug]))
            ->assertResponseStatus(404);
    }

    /** @test */
    function contactable_users_profile_pages_show_contact()
    {
        $this->disableExceptionHandling();

        $user = User::factory()->create([
            'profile_slug' => 'jimmybob',
            'enable_profile' => true,
            'allow_profile_contact' => true,
        ]);

        $this->visit(route('speakers-public.show', [$user->profile_slug]))
            ->see("Contact {$user->name}");

        $this->visit(route('speakers-public.email', [$user->profile_slug]))
            ->assertResponseOk();

        //sending email in next test
    }

    /** @test */
    function user_can_be_contacted_from_profile()
    {
        Mail::fake();
        app()->instance(Captcha::class, new FakeCaptcha);

        $userA = User::factory()->create([
            'profile_slug' => 'smithy',
            'enable_profile' => true,
            'allow_profile_contact' => true,
        ]);
        $userB = User::factory()->create();

        $this->actingAs($userB)
            ->visit(route('speakers-public.email', [$userA->profile_slug]))
            ->type($userB->email, '#email')
            ->type($userB->name, '#name')
            ->type('You are amazing', '#message')
            ->press('Send');

        Mail::assertSent(ContactRequest::class, function ($mail) use ($userA) {
            return $mail->hasTo($userA->email) &&
                       $mail->userMessage == 'You are amazing';
        });
    }

    /** @test */
    function disabled_profile_user_cannot_be_contacted()
    {
        $user = User::factory()->create([
            'profile_slug' => 'alphabetsoup',
            'enable_profile' => false,
            'allow_profile_contact' => true,
        ]);

        $this->get(route('speakers-public.email', [$user->profile_slug]))
            ->assertResponseStatus(404);

        $this->post(route('speakers-public.email', [$user->profile_slug]), ['_token' => csrf_token()])
            ->assertResponseStatus(404);
    }

    /** @test */
    function public_profile_pages_do_not_show_talks_for_other_users()
    {
        $user = User::factory()->create([
            'profile_slug' => 'jinkerjanker',
            'email' => 'a@b.com',
            'enable_profile' => true,
        ]);

        $user2 = User::factory()->create([
            'profile_slug' => 'alcatraz',
            'email' => 'c@d.com',
            'enable_profile' => true,
        ]);

        $talk = Talk::factory()->create();
        $talk->public = true;
        $user2->talks()->save($talk);
        $talkRevision = TalkRevision::factory()->create();
        $talk->revisions()->save($talkRevision);

        $this->visit(route('speakers-public.show', [$user->profile_slug]))
            ->dontSee($talk->current()->title);
    }

    /** @test */
    function public_profile_pages_do_not_show_bios_for_other_users()
    {
        $user = User::factory()->create([
            'profile_slug' => 'stampede',
            'email' => 'a@b.com',
            'enable_profile' => true,
        ]);

        $user2 = User::factory()->create([
            'profile_slug' => 'cruising',
            'email' => 'c@d.com',
            'enable_profile' => true,
        ]);

        $bio = Bio::factory()->create(['nickname' => 'test bio']);
        $bio->public = true;
        $user2->bios()->save($bio);

        $this->visit(route('speakers-public.show', [$user->profile_slug]))
            ->dontSee('test bio');
    }
}
