<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\User;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    /** @test */
    function unapproved_conferences_do_not_appear_on_the_calendar()
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
}
