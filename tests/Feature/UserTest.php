<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\Talk;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_checks_if_user_is_admin(): void
    {
        $user = User::factory()->create();
        $this->assertEquals(0, $user->role);
        $this->assertFalse($user->isAdmin());

        $admin = User::factory()->admin()->create();
        $this->assertEquals(1, $admin->role);
        $this->assertTrue($admin->isAdmin());
    }

    /** @test */
    public function it_returns_all_users_subscribed_to_notifications(): void
    {
        User::factory()->create();
        User::factory()->wantsNotifications()->create();

        $this->assertEquals(1, User::wantsNotifications()->count());
    }

    /** @test */
    public function archived_talks_are_not_included_in_the_talks_relationship(): void
    {
        $user = User::factory()->create();
        $activeTalk = Talk::factory()->author($user)->create();
        $archivedTalk = Talk::factory()->author($user)->archived()->create();

        $activeTalks = $user->talks()->get();

        $this->assertContains($activeTalk->id, $activeTalks->pluck('id'));
        $this->assertNotContains($archivedTalk->id, $activeTalks->pluck('id'));
    }

    public function only_admins_can_access_filament()
    {
        $user = User::factory()->create();
        $admin = User::factory()->admin()->create();

        $this->assertFalse($user->canAccessFilament());
        $this->assertTrue($admin->canAccessFilament());
    }

    /** @test */
    public function getting_conference_submissions(): void
    {
        $user = User::factory()->create();
        $talk = Talk::factory()->author($user)->create();
        $conference = Conference::factory()->create();

        $conference->submissions()->create([
            'talk_revision_id' => $talk->loadCurrentRevision()->currentRevision->id,
        ]);

        $this->assertEquals(1, $user->talkRevisions()->count());
        $this->assertEquals(1, $user->submissions()->count());
        $this->assertEquals(
            $talk->currentRevision->id,
            $user->submissions->first()->talk_revision_id,
        );
    }
}
