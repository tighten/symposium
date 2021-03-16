<?php

namespace Tests;

use App\Conference;
use App\User;

class AdminTest extends IntegrationTestCase
{
    /** @test */
    function admins_can_edit_other_peoples_conferences()
    {
        $user = factory(User::class)->create();
        $user->conferences()->save($conference = factory(Conference::class)->make());

        $admin = factory(User::class)->states('admin')->create();

        $this->actingAs($admin)
            ->patch(
                route('conferences.update', $conference),
                array_merge(
                    $conference->fresh()->toArray(),
                    ['title' => 'The New Name That Is Not The Old Name']
                )
            );

        $this->assertEquals('The New Name That Is Not The Old Name', $conference->fresh()->title);
    }

    /** @test */
    function admins_can_see_edit_button_for_other_peoples_conferences()
    {
        $admin = factory(User::class)->states('admin')->create();
        $conference = factory(Conference::class)->create();

        $this->actingAs($admin)
            ->visit(route('conferences.show', $conference))
            ->see('Edit');
    }

    /** @test */
    function only_admins_can_change_conference_status()
    {
        $user = factory(User::class)->create();
        $user->conferences()->save($conference = factory(Conference::class)->make([
            'is_approved' => false,
        ]));

        $admin = factory(User::class)->states('admin')->create();

        $this->actingAs($user)
            ->patch(
                route('conferences.update', $conference),
                array_merge(
                    $conference->fresh()->toArray(),
                    ['is_approved' => true]
                )
            );

        $this->assertFalse($conference->fresh()->is_approved);

        $this->actingAs($admin)
            ->patch(
                route('conferences.update', $conference),
                array_merge(
                    $conference->fresh()->toArray(),
                    ['is_approved' => true]
                )
            );

        $this->assertTrue($conference->fresh()->is_approved);
    }
}
