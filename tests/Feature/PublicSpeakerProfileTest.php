<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use App\Mail\ContactRequest;
use App\Models\Bio;
use App\Models\Talk;
use App\Models\TalkRevision;
use App\Models\User;
use App\Services\FakeCaptcha;
use Captcha\Captcha;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

final class PublicSpeakerProfileTest extends TestCase
{
    #[Test]
    public function non_public_speakers_are_not_listed_on_the_public_speaker_page(): void
    {
        $user = User::factory()->disableProfile()->create();

        $this->get(route('speakers-public.index'))
            ->assertDontSee($user->name);
    }

    #[Test]
    public function public_speakers_are_listed_on_the_public_speaker_page(): void
    {
        $user = User::factory()->enableProfile()->create([
            'profile_slug' => 'mattstauffer',
        ]);

        $this->get(route('speakers-public.index'))
            ->assertSee($user->name);
    }

    #[Test]
    public function speakers_can_be_found_by_searching_state_abbreviation(): void
    {
        User::factory()->enableProfile()->create([
            'name' => 'Caleb Dume',
            'state' => 'MA',
        ]);
        User::factory()->enableProfile()->create([
            'name' => 'Ezra Bridger',
            'state' => 'NY',
        ]);

        $response = $this->get(route('speakers-public.index', [
            'query' => 'MA',
        ]))->assertSuccessful();

        $response->assertSee('Caleb Dume');
        $response->assertDontSee('Ezra Bridger');
    }

    #[Test]
    public function searching_by_state_abbreviation_is_case_insensitive(): void
    {
        User::factory()->enableProfile()->create([
            'name' => 'Caleb Dume',
            'state' => 'MA',
        ]);
        User::factory()->enableProfile()->create([
            'name' => 'Ezra Bridger',
            'state' => 'NY',
        ]);

        $response = $this->get(route('speakers-public.index', [
            'query' => 'ma',
        ]))->assertSuccessful();

        $response->assertSee('Caleb Dume');
        $response->assertDontSee('Ezra Bridger');
    }

    #[Test]
    public function speakers_can_be_found_by_searching_state_name(): void
    {
        User::factory()->enableProfile()->create([
            'name' => 'Caleb Dume',
            'state' => 'MA',
        ]);
        User::factory()->enableProfile()->create([
            'name' => 'Ezra Bridger',
            'state' => 'NY',
        ]);

        $response = $this->get(route('speakers-public.index', [
            'query' => 'Massachusetts',
        ]))->assertSuccessful();

        $response->assertSee('Caleb Dume');
        $response->assertDontSee('Ezra Bridger');
    }

    #[Test]
    public function searching_by_state_name_is_case_insensitive(): void
    {
        User::factory()->enableProfile()->create([
            'name' => 'Caleb Dume',
            'state' => 'SC',
        ]);
        User::factory()->enableProfile()->create([
            'name' => 'Ezra Bridger',
            'state' => 'NY',
        ]);

        $response = $this->get(route('speakers-public.index', [
            'query' => 'souTh caroLina',
        ]))->assertSuccessful();

        $response->assertSee('Caleb Dume');
        $response->assertDontSee('Ezra Bridger');
    }

    #[Test]
    public function non_public_speakers_do_not_have_public_speaker_profile_pages(): void
    {
        $user = User::factory()->disableProfile()->create([
            'profile_slug' => 'mattstauffer',
        ]);

        $response = $this->get(route('speakers-public.show', [$user->profile_slug]));

        $response->assertNotFound();
    }

    #[Test]
    public function public_speakers_have_public_speaker_profile_pages(): void
    {
        $user = User::factory()->enableProfile()->create([
            'profile_slug' => 'abrahamlincoln',
        ]);

        $this->get(route('speakers-public.show', [$user->profile_slug]))
            ->assertSee($user->name);
    }

    #[Test]
    public function talks_marked_not_public_are_not_listed_publicly(): void
    {
        $user = User::factory()->enableProfile()->create([
            'profile_slug' => 'tonimorrison',
        ]);

        $talk = Talk::factory()->create();
        $talk->public = false;
        $user->talks()->save($talk);
        $talkRevision = TalkRevision::factory()->create();
        $talk->revisions()->save($talkRevision);

        $response = $this->get(route('speakers-public.show', [$user->profile_slug]));

        $response->assertSuccessful();
        $response->assertDontSee($talkRevision->title);
    }

    #[Test]
    public function talks_marked_not_public_do_not_have_public_pages(): void
    {
        $user = User::factory()->enableProfile()->create([
            'profile_slug' => 'jamesandthegiantpeach',
        ]);

        $talk = Talk::factory()->create();
        $talk->public = false;
        $user->talks()->save($talk);
        $talkRevision = TalkRevision::factory()->create();
        $talk->revisions()->save($talkRevision);

        $response = $this->get(route('speakers-public.talks.show', [
            $user->profile_slug,
            $talk->id,
        ]));

        $response->assertNotFound();
    }

    #[Test]
    public function talks_marked_public_are_listed_publicly(): void
    {
        $user = User::factory()->enableProfile()->create([
            'profile_slug' => 'zipporah',
        ]);

        $talk = Talk::factory()->create();
        $talk->public = true;
        $user->talks()->save($talk);
        $talkRevision = TalkRevision::factory()->create();
        $talk->revisions()->save($talkRevision);

        $response = $this->get(route('speakers-public.show', [$user->profile_slug]));

        $response->assertSuccessful();
        $response->assertSee($talkRevision->title);
    }

    #[Test]
    public function bios_marked_public_are_listed_publicly(): void
    {
        $user = User::factory()->enableProfile()->create([
            'profile_slug' => 'esther',
        ]);

        $bio = Bio::factory()->create();
        $bio->public = false;
        $user->bios()->save($bio);

        $response = $this->get(route('speakers-public.show', [$user->profile_slug]));

        $response->assertSuccessful();
        $response->assertSee($bio->title);
    }

    #[Test]
    public function bios_marked_not_public_do_not_have_public_pages(): void
    {
        $user = User::factory()->enableProfile()->create([
            'profile_slug' => 'kuntakinte',
        ]);

        Bio::factory()->for($user)->private()->create([
            'nickname' => 'Private Bio',
        ]);

        $response = $this->get(route('speakers-public.show', [$user->profile_slug]));

        $response->assertDontSee('Private Bio');
    }

    #[Test]
    public function bios_marked_public_have_public_pages(): void
    {
        $user = User::factory()->enableProfile()->create([
            'profile_slug' => 'mydearauntsally',
        ]);

        $bio = Bio::factory()->create();
        $bio->public = true;
        $user->bios()->save($bio);

        $response = $this->get(route('speakers-public.show', [$user->profile_slug]));

        $response->assertSee($bio->nickname);
    }

    #[Test]
    public function public_profile_page_is_off_by_default(): void
    {
        $user = User::factory()->create([
            'profile_slug' => 'jimmybob',
        ]);

        $response = $this->get(route('speakers-public.show', [$user->profile_slug]));

        $response->assertNotFound();
    }

    #[Test]
    public function non_contactable_users_profile_pages_do_not_show_contact(): void
    {
        $this->withoutMiddleware();

        $user = User::factory()->enableProfile()->create([
            'profile_slug' => 'jimmybob',
            'allow_profile_contact' => false,
        ]);

        $this->get(route('speakers-public.show', [$user->profile_slug]))
            ->assertDontSee("Contact {$user->name}");

        $this->get(route('speakers-public.email', [$user->profile_slug]))
            ->assertNotFound();

        $this->post(route('speakers-public.email', [$user->profile_slug]))
            ->assertNotFound();
    }

    #[Test]
    public function contactable_users_profile_pages_show_contact(): void
    {
        $user = User::factory()->enableProfile()->create([
            'profile_slug' => 'jimmybob',
            'allow_profile_contact' => true,
        ]);

        $this->get(route('speakers-public.show', [$user->profile_slug]))
            ->assertSee("Contact {$user->name}");

        $this->get(route('speakers-public.email', [$user->profile_slug]))
            ->assertSuccessful();

        //sending email in next test
    }

    #[Test]
    public function user_can_be_contacted_from_profile(): void
    {
        Mail::fake();
        app()->instance(Captcha::class, new FakeCaptcha);

        $userA = User::factory()->enableProfile()->create([
            'profile_slug' => 'smithy',
            'allow_profile_contact' => true,
        ]);
        $userB = User::factory()->create();

        $this->actingAs($userB)
            ->post(route('speakers-public.email.send', [$userA->profile_slug]), [
                'email' => $userB->email,
                'name' => $userB->name,
                'message' => 'You are amazing',
            ]);

        Mail::assertSent(ContactRequest::class, function ($mail) use ($userA) {
            return $mail->hasTo($userA->email) &&
                       $mail->userMessage == 'You are amazing';
        });
    }

    #[Test]
    public function disabled_profile_user_cannot_be_contacted(): void
    {
        $user = User::factory()->disableProfile()->create([
            'profile_slug' => 'alphabetsoup',
            'allow_profile_contact' => true,
        ]);

        $this->get(route('speakers-public.email', [$user->profile_slug]))
            ->assertNotFound();

        $this->post(route('speakers-public.email', [$user->profile_slug]), ['_token' => csrf_token()])
            ->assertNotFound();
    }

    #[Test]
    public function public_profile_pages_do_not_show_talks_for_other_users(): void
    {
        $user = User::factory()->enableProfile()->create([
            'profile_slug' => 'jinkerjanker',
            'email' => 'a@b.com',
        ]);

        $user2 = User::factory()->enableProfile()->create([
            'profile_slug' => 'alcatraz',
            'email' => 'c@d.com',
        ]);

        $talk = Talk::factory()->create();
        $talk->public = true;
        $user2->talks()->save($talk);
        $talkRevision = TalkRevision::factory()->create();
        $talk->revisions()->save($talkRevision);

        $talk->loadCurrentRevision();

        $this->get(route('speakers-public.show', [$user->profile_slug]))
            ->assertDontSee($talk->currentRevision->title);
    }

    #[Test]
    public function public_profile_pages_do_not_show_bios_for_other_users(): void
    {
        $user = User::factory()->enableProfile()->create([
            'profile_slug' => 'stampede',
            'email' => 'a@b.com',
        ]);

        $user2 = User::factory()->enableProfile()->create([
            'profile_slug' => 'cruising',
            'email' => 'c@d.com',
        ]);

        $bio = Bio::factory()->create(['nickname' => 'test bio']);
        $bio->public = true;
        $user2->bios()->save($bio);

        $this->get(route('speakers-public.show', [$user->profile_slug]))
            ->assertDontSee('test bio');
    }
}
