<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class ConferenceTest extends TestCase
{
    /** @test */
    function user_can_create_conference()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('conferences', [
                'title' => 'Das Conf',
                'description' => 'A very good conference about things',
                'url' => 'http://dasconf.org',
            ]);

        $this->assertDatabaseHas(Conference::class, [
            'title' => 'Das Conf',
            'description' => 'A very good conference about things',
        ]);
    }

    /** @test */
    function a_conference_can_include_location_coordinates()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('conferences', [
                'title' => 'JediCon',
                'description' => 'The force is strong here',
                'url' => 'https://jedicon.com',
                'latitude' => '37.7991531',
                'longitude' => '-122.45050129999998',
            ]);

        $this->assertDatabaseHas(Conference::class, [
            'title' => 'JediCon',
            'description' => 'The force is strong here',
            'url' => 'https://jedicon.com',
            'latitude' => '37.7991531',
            'longitude' => '-122.45050129999998',
        ]);
    }

    /** @test */
    function a_conference_cannot_end_before_it_begins()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('conferences', [
                'title' => 'JediCon',
                'description' => 'The force is strong here',
                'url' => 'https://jedicon.com',
                'starts_at' => Carbon::parse('+3 days')->toDateString(),
                'ends_at' => Carbon::parse('+2 days')->toDateString(),
            ]);

        $response->assertRedirect('conferences/create');
        $this->assertDatabaseMissing('conferences', [
            'title' => 'JediCon',
        ]);
    }

    /** @test */
    function user_can_edit_conference()
    {
        $user = User::factory()->create();

        $conference = Conference::factory()->author($user->id)->approved()->create([
            'title' => 'Rubycon',
            'description' => 'A conference about Ruby',
        ]);

        $this->actingAs($user)
            ->put("conferences/{$conference->id}", [
                'title' => 'Laracon',
                'description' => 'A conference about Laravel',
                'url' => $conference->url,
            ]);

        $this->assertDatabaseHas(Conference::class, [
            'title' => 'Laracon',
            'description' => 'A conference about Laravel',
        ]);

        $this->assertDatabaseMissing(Conference::class, [
            'title' => 'Rubycon',
            'description' => 'A conference about Ruby',
        ]);
    }

    /** @test */
    function location_coordinates_can_be_updated()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()->author($user->id)->create();

        $this->actingAs($user)
            ->put("/conferences/{$conference->id}", array_merge($conference->toArray(), [
                'title' => 'Updated JediCon',
                'latitude' => '37.7991531',
                'longitude' => '-122.45050129999998',
            ]));

        $this->assertDatabaseHas(Conference::class, [
            'title' => 'Updated JediCon',
            'latitude' => '37.7991531',
            'longitude' => '-122.45050129999998',
        ]);
    }

    /** @test */
    function a_conference_cannot_be_updated_to_end_before_it_begins()
    {
        $user = User::factory()->create();

        $conference = Conference::factory()->author($user->id)->approved()->create([
            'title' => 'Rubycon',
            'description' => 'A conference about Ruby',
            'starts_at' => Carbon::parse('+3 days')->toDateString(),
            'ends_at' => Carbon::parse('+4 days')->toDateString(),
        ]);

        $response = $this->actingAs($user)
            ->put("conferences/{$conference->id}", array_merge($conference->toArray(), [
                'ends_at' => Carbon::parse('+2 days')->toDateString(),
            ]));

        $response->assertSessionHasErrors('ends_at');
        $this->assertEquals(
            Carbon::parse('+4 days')->toDateString(),
            $conference->fresh()->ends_at->toDateString(),
        );
    }

    /** @test */
    function conferences_accept_proposals_during_the_call_for_papers()
    {
        $conference = Conference::factory()->create([
            'cfp_starts_at' => Carbon::yesterday(),
            'cfp_ends_at' => Carbon::tomorrow(),
        ]);

        $this->assertTrue($conference->isCurrentlyAcceptingProposals());
    }

    /** @test */
    function conferences_dont_accept_proposals_outside_of_the_call_for_papers()
    {
        $conference = Conference::factory()->create([
            'cfp_starts_at' => Carbon::tomorrow(),
            'cfp_ends_at' => Carbon::tomorrow()->addDay(),
        ]);

        $this->assertFalse($conference->isCurrentlyAcceptingProposals());

        $conference = Conference::factory()->create([
            'cfp_starts_at' => Carbon::yesterday()->subDay(),
            'cfp_ends_at' => Carbon::yesterday(),
        ]);

        $this->assertFalse($conference->isCurrentlyAcceptingProposals());
    }

    /** @test */
    function conferences_that_havent_announced_their_cfp_are_not_accepting_proposals()
    {
        $conference = Conference::factory()->create([
            'cfp_starts_at' => null,
            'cfp_ends_at' => null,
        ]);

        $this->assertFalse($conference->isCurrentlyAcceptingProposals());
    }

    /** @test */
    function non_owners_can_view_conference()
    {
        $user = User::factory()->create();

        $otherUser = User::factory()->create();
        $conference = Conference::factory()->create();
        $otherUser->conferences()->save($conference);

        $this->actingAs($user)
            ->get("conferences/{$conference->id}")
            ->assertSee($conference->title);
    }

    /** @test */
    function guests_can_view_conference()
    {
        $conference = Conference::factory()->approved()->create();

        $this->get("conferences/{$conference->id}")
            ->assertSee($conference->title);
    }

    /** @test */
    function guests_can_view_conference_list()
    {
        $user = User::factory()->create();

        $conference = Conference::factory()->approved()->create();
        $user->conferences()
            ->save($conference);

        $this->get('conferences?filter=all')
            ->assertSee($conference->title);
    }

    /** @test */
    function guests_cannot_create_conference()
    {
        $this->get('conferences/create')
            ->assertRedirect('login');
    }

    /** @test */
    function it_can_pull_only_approved_conferences()
    {
        Conference::factory()->create();
        Conference::factory()->approved()->create();

        $this->assertEquals(1, Conference::approved()->count());
    }

    /** @test */
    function it_can_pull_only_not_shared_conferences()
    {
        Conference::factory()->create();
        Conference::factory()->shared()->create();

        $this->assertEquals(1, Conference::notShared()->count());
    }

    /** @test */
    function cfp_closing_next_list_sorts_null_cfp_to_the_bottom()
    {
        $nullCfp = Conference::factory()->approved()->create([
            'cfp_starts_at' => null,
            'cfp_ends_at' => null,
        ]);
        $pastCfp = Conference::factory()->approved()->create([
            'cfp_starts_at' => Carbon::yesterday()->subDay(),
            'cfp_ends_at' => Carbon::yesterday(),
        ]);
        $futureCfp = Conference::factory()->approved()->create([
            'cfp_starts_at' => Carbon::yesterday(),
            'cfp_ends_at' => Carbon::tomorrow(),
        ]);

        $response = $this->get('conferences');

        $this->assertConferenceSort([
            $pastCfp,
            $futureCfp,
            $nullCfp,
        ], $response);
    }

    /** @test */
    function cfp_by_date_list_sorts_by_date()
    {
        $conferenceA = Conference::factory()->approved()->create([
            'starts_at' => Carbon::now()->subDay(),
        ]);
        $conferenceB = Conference::factory()->approved()->create([
            'starts_at' => Carbon::now()->addDay(),
        ]);

        $response = $this->get('conferences?filter=all&sort=date');

        $this->assertConferenceSort([
            $conferenceA,
            $conferenceB,
        ], $response);
    }

    /** @test */
    function guests_cannot_dismiss_conference()
    {
        $user = User::factory()->create();

        $conference = Conference::factory()->create();
        $user->conferences()->save($conference);

        $this->get("conferences/{$conference->id}/dismiss")
            ->assertRedirect('login');
    }

    /** @test */
    function dismissed_conferences_do_not_show_up_in_conference_list()
    {
        $user = User::factory()->create();

        $conference = Conference::factory()->approved()->create();
        $user->conferences()->save($conference);

        $this->actingAs($user)
            ->get('conferences?filter=all')
            ->assertSee($conference->title);

        $this->actingAs($user)
            ->get("conferences/{$conference->id}/dismiss");

        $this->actingAs($user)
            ->get('conferences?filter=all')
            ->assertDontSee($conference->title);
    }

    /** @test */
    function filtering_by_dismissed_shows_dismissed_conferences()
    {
        $user = User::factory()->create();

        $conference = Conference::factory()->approved()->create();
        $user->conferences()->save($conference);

        $this->actingAs($user)
            ->get("conferences/{$conference->id}/dismiss");

        $this->actingAs($user)
            ->get('conferences?filter=dismissed')
            ->assertSee($conference->title);
    }

    /** @test */
    function filtering_by_dismissed_does_not_show_undismissed_conferences()
    {
        $user = User::factory()->create();

        $conference = Conference::factory()->create();
        $user->conferences()->save($conference);

        $this->actingAs($user)
            ->get('conferences?filter=dismissed')
            ->assertDontSee($conference->title);
    }

    /** @test */
    function filtering_by_favorites_shows_favorite_conferences()
    {
        $user = User::factory()->create();

        $conference = Conference::factory()->approved()->create();
        $user->conferences()->save($conference);

        $this->actingAs($user)
            ->get("conferences/{$conference->id}/favorite");

        $this->actingAs($user)
            ->get('conferences?filter=favorites')
            ->assertSee($conference->title);
    }

    /** @test */
    function filtering_by_favorites_does_not_show_nonfavorite_conferences()
    {
        $user = User::factory()->create();

        $conference = Conference::factory()->create();
        $user->conferences()->save($conference);

        $this->actingAs($user)
            ->get('conferences?filter=favorites')
            ->assertDontSee($conference->title);
    }

    /** @test */
    function a_favorited_conference_cannot_be_dismissed()
    {
        $user = User::factory()->create();

        $conference = Conference::factory()->approved()->create();
        $user->favoritedConferences()->save($conference);

        $this->actingAs($user)
            ->get("conferences/{$conference->id}/dismiss");

        $this->actingAs($user)
            ->get('conferences?filter=dismissed')
            ->assertDontSee($conference->title);
    }

    /** @test */
    function a_dismissed_conference_cannot_be_favorited()
    {
        $user = User::factory()->create();

        $conference = Conference::factory()->approved()->create();
        $user->dismissedConferences()->save($conference);

        $this->actingAs($user)
            ->get("conferences/{$conference->id}/favorite");

        $this->actingAs($user)
            ->get('conferences?filter=favorites')
            ->assertDontSee($conference->title);
    }

    /** @test */
    function displaying_event_dates_with_no_dates_set()
    {
        $conference = Conference::factory()->make([
            'starts_at' => null,
            'ends_at' => null,
        ]);

        $this->assertNull($conference->event_dates_display);
    }

    /** @test */
    function displaying_event_dates_with_a_start_date_and_no_end_date()
    {
        $conference = Conference::factory()->make([
            'starts_at' => '2020-01-01 09:00:00',
            'ends_at' => null,
        ]);

        $this->assertEquals('Jan 1 2020', $conference->event_dates_display);
    }

    /** @test */
    function displaying_event_dates_with_an_end_date_and_no_start_date()
    {
        $conference = Conference::factory()->make([
            'starts_at' => null,
            'ends_at' => '2020-01-01 09:00:00',
        ]);

        $this->assertNull($conference->event_dates_display);
    }

    /** @test */
    function displaying_event_dates_with_the_same_start_and_end_dates()
    {
        $conference = Conference::factory()->make([
            'starts_at' => '2020-01-01 09:00:00',
            'ends_at' => '2020-01-01 16:00:00',
        ]);

        $this->assertEquals('Jan 1 2020', $conference->event_dates_display);
    }

    /** @test */
    function displaying_event_dates_with_the_different_start_and_end_dates()
    {
        $conference = Conference::factory()->make([
            'starts_at' => '2020-01-01 09:00:00',
            'ends_at' => '2020-01-03 16:00:00',
        ]);

        $this->assertEquals('Jan 1 2020 - Jan 3 2020', $conference->event_dates_display);
    }

    function assertConferenceSort($conferences, $response)
    {
        foreach ($conferences as $sortPosition => $conference) {
            $sortedConference = $response->original->getData()['conferences']->values()[$sortPosition];

            $this->assertTrue($sortedConference->is($conference), "Conference ID {$conference->id} was expected in position {$sortPosition}, but {$sortedConference->id } was in position {$sortPosition}.");
        }
    }

    /** @test */
    function scopping_conferences_queries_where_has_dates()
    {
        $conferenceA = Conference::factory()->create(['starts_at' => Carbon::parse('yesterday'), 'ends_at' => Carbon::parse('tomorrow')]);
        $conferenceB = Conference::factory()->create(['starts_at' => Carbon::parse('yesterday'), 'ends_at' => null]);
        $conferenceC = Conference::factory()->create(['starts_at' => null, 'ends_at' => Carbon::parse('tomorrow')]);
        $conferenceD = Conference::factory()->create(['starts_at' => null, 'ends_at' => null]);

        $conferenceIds = Conference::whereHasDates()->get()->pluck('id');

        $this->assertContains($conferenceA->id, $conferenceIds);
        $this->assertNotContains($conferenceB->id, $conferenceIds);
        $this->assertNotContains($conferenceC->id, $conferenceIds);
        $this->assertNotContains($conferenceD->id, $conferenceIds);
    }

    /** @test */
    function scopping_conferences_queries_where_has_cfp_start_date()
    {
        $conferenceA = Conference::factory()->create(['cfp_starts_at' => Carbon::parse('yesterday')]);
        $conferenceB = Conference::factory()->create(['cfp_starts_at' => null]);

        $conferenceIds = Conference::whereHasCfpStart()->get()->pluck('id');

        $this->assertContains($conferenceA->id, $conferenceIds);
        $this->assertNotContains($conferenceB->id, $conferenceIds);
    }

    /** @test */
    function scopping_conferences_queries_where_has_cfp_end_date()
    {
        $conferenceA = Conference::factory()->create(['cfp_ends_at' => Carbon::parse('yesterday')]);
        $conferenceB = Conference::factory()->create(['cfp_ends_at' => null]);

        $conferenceIds = Conference::whereHasCfpEnd()->get()->pluck('id');

        $this->assertContains($conferenceA->id, $conferenceIds);
        $this->assertNotContains($conferenceB->id, $conferenceIds);
    }
}
