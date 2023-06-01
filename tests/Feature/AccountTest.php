<?php

namespace Tests\Feature;

use App\Http\Livewire\ConferenceList;
use App\Models\Bio;
use App\Models\Conference;
use App\Models\Talk;
use App\Models\TalkRevision;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AccountTest extends TestCase
{
    /** @test */
    public function users_can_log_in()
    {
        $user = User::factory()->create(['password' => Hash::make('super-secret')]);

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'super-secret',
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionDoesntHaveErrors('email');
    }

    /** @test */
    public function logging_in_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'incorrect-password',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_can_update_their_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('account/edit', [
            'name' => 'Kevin Bacon',
            'email' => 'KevinBacon@yahoo.com',
            'password' => 'haxTh1sn00b',
            'enable_profile' => true,
            'allow_profile_contact' => true,
            'wants_notifications' => true,
            'profile_slug' => 'kevin_rox',
            'profile_intro' => 'It has been so long since I was in an X-Men movie',
        ]);

        $response->assertRedirect('account');

        $this->assertDatabaseHas(User::class, [
            'name' => 'Kevin Bacon',
            'email' => 'KevinBacon@yahoo.com',
            'enable_profile' => 1,
            'allow_profile_contact' => 1,
            'profile_slug' => 'kevin_rox',
            'profile_intro' => 'It has been so long since I was in an X-Men movie',
            'wants_notifications' => 1,
        ]);
    }

    /** @test */
    public function user_can_update_their_profile_picture()
    {
        Storage::fake();

        $user = User::factory()->create();

        $this->actingAs($user)->put('account/edit', [
            'name' => $user->name,
            'email' => $user->email,
            'enable_profile' => true,
            'allow_profile_contact' => true,
            'wants_notifications' => true,
            'profile_picture' => UploadedFile::fake()->image('test.jpg'),
        ]);

        $this->assertNotNull($user->fresh()->profile_picture);
        Storage::disk()->assertExists(User::PROFILE_PICTURE_THUMB_PATH . $user->profile_picture);
        Storage::disk()->assertExists(User::PROFILE_PICTURE_HIRES_PATH . $user->profile_picture);
    }

    /** @test */
    public function password_reset_emails_are_sent_for_valid_users()
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->post('password/email', [
            'email' => $user->email,
        ]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /** @test */
    public function user_can_reset_their_password_from_email_link()
    {
        Notification::fake();

        $user = User::factory()->create();
        $token = null;

        $this->post('/password/email', [
            'email' => $user->email,
            '_token' => csrf_token(),
        ]);

        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            function ($notification, $channels) use (&$token) {
                $token = $notification->token;

                return true;
            }
        );

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'h4xmahp4ssw0rdn00bz',
            'password_confirmation' => 'h4xmahp4ssw0rdn00bz',
        ]);

        $response->assertRedirect('dashboard');

        $this->post('logout');

        $this->post('login', [
            'email' => $user->email,
            'password' => 'h4xmahp4ssw0rdn00bz',
        ])->assertLocation('dashboard');
    }

    /** @test */
    public function users_can_delete_their_accounts()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('account/delete');

        $response->assertRedirect('/');

        $this->assertModelMissing($user);
    }

    /** @test */
    public function deleting_a_user_deletes_its_associated_entities()
    {
        $user = User::factory()->create();
        $talk = Talk::factory()->author($user)->create();
        $talkRevision = TalkRevision::factory()->create();
        $bio = Bio::factory()->create();
        $conferenceA = Conference::factory()->create();
        $conferenceB = Conference::factory()->create();

        $user->talks()->save($talk);
        $talk->revisions()->save($talkRevision);
        $user->bios()->save($bio);
        $user->conferences()->saveMany([$conferenceA, $conferenceB]);

        $otherUser = User::factory()->create();
        $dismissedConference = Conference::factory()->create();
        $favoriteConference = Conference::factory()->create();

        $otherUser->conferences()->saveMany([$conferenceA, $conferenceB]);
        $user->dismissedConferences()->save($dismissedConference);
        $user->favoritedConferences()->save($favoriteConference);

        $this->actingAs($user)
            ->post('account/delete')
            ->assertRedirect('/');

        $this->assertModelMissing($user);
        $this->assertModelMissing($talk);
        $this->assertModelMissing($bio);

        $this->assertDatabaseMissing('dismissed_conferences', [
            'user_id' => $user->id,
            'conference_id' => $dismissedConference->id,
        ]);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'conference_id' => $favoriteConference->id,
        ]);
    }

    /** @test */
    public function users_can_dismiss_a_conference()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->create();

        Livewire::actingAs($user)
            ->test(ConferenceList::class)
            ->call('toggleDismissed', $conference);

        $this->assertDatabaseHas('dismissed_conferences', [
            'user_id' => $user->id,
            'conference_id' => $conference->id,
        ]);
    }

    /** @test */
    public function users_can_undismiss_a_conference()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->dismissedBy($user)->create();

        Livewire::actingAs($user)
            ->test(ConferenceList::class)
            ->call('toggleDismissed', $conference);

        $this->assertDatabaseMissing('dismissed_conferences', [
            'user_id' => $user->id,
            'conference_id' => $conference->id,
        ]);
    }

    /** @test */
    public function users_can_favorite_a_conference()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->create();

        Livewire::actingAs($user)
            ->test(ConferenceList::class)
            ->call('toggleFavorite', $conference);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'conference_id' => $conference->id,
        ]);
    }

    /** @test */
    public function users_can_unfavorite_a_conference()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->favoritedBy($user)->create();

        Livewire::actingAs($user)
            ->test(ConferenceList::class)
            ->call('toggleFavorite', $conference);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'conference_id' => $conference->id,
        ]);
    }
}
