<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\User;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    /** @test */
    public function unapproved_conferences_do_not_appear_on_the_calendar()
    {
        $user = User::factory()->create();

        Conference::factory()->notApproved()->create([
            'title' => 'Unapproved conference',
        ]);

        Conference::factory()->approved()->create([
            'title' => 'Approved conference',
        ]);

        $this->actingAs($user)->get('calendar')
            ->assertSuccessful()
            ->assertSee('Approved conference')
            ->assertDontSee('Unapproved conference');
    }

    /** @test */
    function user_dismissed_conferences_do_not_appear_on_the_calendar()
    {
        $user = User::factory()->create();

        Conference::factory()->approved()->dismissedBy($user)->create([
            'title' => 'Dismissed conference',
        ]);

        Conference::factory()->approved()->create([
            'title' => 'Approved conference',
        ]);

        $this->actingAs($user)->get('calendar')
            ->assertSuccessful()
            ->assertSee('Approved conference')
            ->assertDontSee('Dismissed conference');
    }
}
