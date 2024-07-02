<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\User;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /** @test */
    public function admins_can_edit_other_peoples_conferences(): void
    {
        $user = User::factory()->create();
        $user->conferences()->save($conference = Conference::factory()->make());

        $admin = User::factory()->admin()->create();

        $this->followingRedirects()
            ->actingAs($admin)
            ->patch(
                route('conferences.update', $conference),
                array_merge(
                    $conference->fresh()->toArray(),
                    ['title' => 'The New Name That Is Not The Old Name']
                )
            )->assertSuccessful();

        $this->assertEquals('The New Name That Is Not The Old Name', $conference->fresh()->title);
    }

    /** @test */
    public function admins_can_see_edit_button_for_other_peoples_conferences(): void
    {
        $admin = User::factory()->admin()->create();
        $conference = Conference::factory()->create();

        $this->actingAs($admin)
            ->get(route('conferences.show', $conference))
            ->assertSee('Edit');
    }

    /** @test */
    public function only_admins_can_change_conference_status(): void
    {
        $user = User::factory()->create();
        $user->conferences()->save($conference = Conference::factory()->notApproved()->make());

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
