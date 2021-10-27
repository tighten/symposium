<?php

namespace Tests\Feature;

use App\Conference;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function unapproved_conferences_do_not_appear_on_the_calendar()
    {
        $user = factory(User::class)->create();

        factory(Conference::class)->create([
            'title' => 'Unapproved conference',
            'is_approved' => false,
        ]);

        factory(Conference::class)->create([
            'title' => 'Approved conference',
            'is_approved' => true,
        ]);

        $this->actingAs($user)->get('calendar')
            ->assertResponseOk()
            ->see('Approved conference')
            ->dontSee('Unapproved conference');

        $this->assertTrue(true);
    }
}
