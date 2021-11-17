<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    function it_checks_if_user_is_admin()
    {
        $user = User::factory()->create();
        $this->assertEquals(0, $user->role);
        $this->assertFalse($user->isAdmin());

        $admin = User::factory()->create(['role' => 1]);
        $this->assertEquals(1, $admin->role);
        $this->assertTrue($admin->isAdmin());
    }

    /** @test */
    function it_returns_all_users_subscribed_to_notifications()
    {
        User::factory()->create();
        User::factory()->wantsNotifications()->create();

        $this->assertEquals(1, User::wantsNotifications()->count());
    }
}
