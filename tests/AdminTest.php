<?php

namespace Tests;

use App\Conference;
use App\User;

class AdminTest extends IntegrationTestCase
{
    /** @test */
    function admins_can_edit_other_peoples_conferences()
    {
        $user = User::factory()->create();
        $user->conferences()->save($conference = Conference::factory()->make());

        $admin = User::factory()->admin()->create();

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
        $admin = User::factory()->admin()->create();
        $conference = Conference::factory()->create();

        $this->actingAs($admin)
            ->visit(route('conferences.show', $conference))
            ->see('Edit');
    }

    /** @test */
    function only_admins_can_change_conference_status()
    {
        $user = User::factory()->create();
        $user->conferences()->save($conference = Conference::factory()->make([
            'is_approved' => false,
        ]));

        $admin = User::factory()->admin()->create();

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
