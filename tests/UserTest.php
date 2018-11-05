<?php

use App\User;

class UserTest extends IntegrationTestCase
{
    /** @test */
    function it_checks_if_user_is_admin()
    {
        $user = factory(User::class)->create();
        $this->assertEquals(0, $user->role);
        $this->assertFalse($user->isAdmin());

        $admin = factory(User::class)->create(['role' => 1]);
        $this->assertEquals(1, $admin->role);
        $this->assertTrue($admin->isAdmin());
    }

    /** @test */
    function it_returns_all_users_subscribed_to_notifications()
    {
        factory(User::class)->create();
        factory(User::class)->create(['enable_notifications' => true]);

        $this->assertEquals(1, User::EnabledNotifications()->count());
    }

}
