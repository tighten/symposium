<?php

namespace Tests\Feature;

use App\Models\Talk;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_checks_if_user_is_admin()
    {
        $user = User::factory()->create();
        $this->assertEquals(0, $user->role);
        $this->assertFalse($user->isAdmin());

        $admin = User::factory()->admin()->create();
        $this->assertEquals(1, $admin->role);
        $this->assertTrue($admin->isAdmin());
    }

    /** @test */
    public function it_returns_all_users_subscribed_to_notifications()
    {
        User::factory()->create();
        User::factory()->wantsNotifications()->create();

        $this->assertEquals(1, User::wantsNotifications()->count());
    }

    /** @test */
    function archived_talks_are_not_included_in_active_talks_relationship()
    {
        $user = User::factory()->create();
        $activeTalk = Talk::factory()->author($user)->create();
        $archivedTalk = Talk::factory()->author($user)->archived()->create();

        $activeTalks = $user->activeTalks()->get();

        $this->assertContains($activeTalk->id, $activeTalks->pluck('id'));
        $this->assertNotContains($archivedTalk->id, $activeTalks->pluck('id'));
    }
}
