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
            ->from('conferences/create')
            ->post('conferences', [
                'title' => 'JediCon',
                'description' => 'The force is strong here',
                'url' => 'https://jedicon.com',
                'starts_at' => Carbon::parse('+3 days')->toDateString(),
                'ends_at' => Carbon::parse('+2 days')->toDateString(),
            ]);

        $response->assertRedirect('conferences/create');
        $response->assertSessionHasErrors('ends_at');
        $this->assertDatabaseMissing('conferences', [
            'title' => 'JediCon',
        ]);
    }

    /** @test */
    function conference_title_is_required()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('conferences', [
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    function conference_description_is_required()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('conferences', [
            'title' => 'AwesomeConf 2015',
            'url' => 'http://example.com',
        ]);

        $response->assertSessionHasErrors('description');
    }

    /** @test */
    function conference_url_is_required()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('conferences', [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
        ]);

        $response->assertSessionHasErrors('url');
    }

    /** @test */
    function conference_start_date_must_be_a_valid_date()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('conferences', [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => 'potato',
        ]);

        $response->assertSessionHasErrors('starts_at');
    }

    /** @test */
    function conference_end_date_must_be_a_valid_date()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('conferences', [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'ends_at' => 'potato',
        ]);

        $response->assertSessionHasErrors('ends_at');
    }

    /** @test */
    function conference_end_date_must_not_be_before_start_date()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('conferences', [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '2015-02-04',
            'ends_at' => '2015-02-01',
        ]);

        $response->assertSessionHasErrors('ends_at');
    }

    /** @test */
    function conference_can_be_a_single_day_conference()
    {
        $user = User::factory()->create();

        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '2015-02-04 00:00:00',
            'ends_at' => '2015-02-04 00:00:00',
        ];

        $this->actingAs($user)->post('conferences', $input);

        $this->assertDatabaseHas(Conference::class, $input);
    }

    /** @test */
    function conference_cfp_start_date_must_be_a_valid_date()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('conferences', [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'cfp_starts_at' => 'potato',
        ]);

        $response->assertSessionHasErrors('cfp_starts_at');
    }

    /** @test */
    function conference_cfp_end_date_must_be_a_valid_date()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('conferences', [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'cfp_ends_at' => 'potato',
        ]);

        $response->assertSessionHasErrors('cfp_ends_at');
    }

    /** @test */
    function conference_cfp_end_date_must_not_be_before_cfp_start_date()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('conferences', [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'cfp_starts_at' => '2015-01-18',
            'cfp_ends_at' => '2015-01-15',
        ]);

        $response->assertSessionHasErrors('cfp_ends_at');
    }

    /** @test */
    function conference_cfp_start_date_must_be_before_the_conference_start_date()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('conferences', [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '2015-02-04',
            'ends_at' => '2015-02-05',
            'cfp_starts_at' => '2015-02-06',
        ]);

        $response->assertSessionHasErrors('cfp_starts_at');
    }

    /** @test */
    function conference_cfp_end_date_must_be_before_the_conference_start_date()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('conferences', [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '2015-02-04',
            'ends_at' => '2015-02-05',
            'cfp_ends_at' => '2015-02-06',
        ]);

        $response->assertSessionHasErrors('cfp_ends_at');
    }

    /** @test */
    function it_creates_a_conference_with_the_minimum_required_input()
    {
        $user = User::factory()->create();
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
        ];

        $this->actingAs($user)->post('conferences', $input);

        $this->assertDatabaseHas(Conference::class, $input);
    }

    /** @test */
    function conference_dates_are_saved_if_provided()
    {
        $user = User::factory()->create();
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '2015-02-01 00:00:00',
            'ends_at' => '2015-02-04 00:00:00',
            'cfp_starts_at' => '2015-01-15 00:00:00',
            'cfp_ends_at' => '2015-01-18 00:00:00',
        ];

        $this->actingAs($user)->post('conferences', $input);

        $this->assertDatabaseHas(Conference::class, $input);
    }

    /** @test */
    function conference_cfp_url_is_saved_if_provided()
    {
        $user = User::factory()->create();
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'cfp_url' => 'http://example.com/cfp',
        ];

        $this->actingAs($user)->post('conferences', $input);

        $this->assertDatabaseHas(Conference::class, $input);
    }

    /** @test */
    function empty_dates_are_treated_as_null()
    {
        $user = User::factory()->create();
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => '',
            'ends_at' => '',
            'cfp_starts_at' => '',
            'cfp_ends_at' => '',
        ];

        $this->actingAs($user)->post('conferences', $input);

        $this->assertDatabaseHas(Conference::class, [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'starts_at' => null,
            'ends_at' => null,
            'cfp_starts_at' => null,
            'cfp_ends_at' => null,
        ]);
    }

    /** @test */
    function non_admins_cannot_submit_admin_only_fields()
    {
        $user = User::factory()->create();
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
            'is_approved' => true,
            'is_shared' => true,
        ];

        $response = $this->actingAs($user)->post('conferences', $input);

        $conference = Conference::firstWhere(['title' => 'AwesomeConf 2015']);
        $this->assertFalse($conference->is_approved);
        $this->assertFalse($conference->is_shared);
    }

    /** @test */
    function creating_a_conference_redirects_to_the_new_conference()
    {
        $user = User::factory()->create();
        $input = [
            'title' => 'AwesomeConf 2015',
            'description' => 'The best conference in the world!',
            'url' => 'http://example.com',
        ];

        $response = $this->actingAs($user)->post('conferences', $input);

        $conference = Conference::firstWhere($input);
        $response->assertRedirect("conferences/{$conference->id}");
    }

    /** @test */
    function a_conference_has_cfp_by_default()
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
            'has_cfp' => true,
        ]);
    }

    /** @test */
    function a_conference_can_be_marked_no_cfp()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('conferences', [
                'title' => 'Das Conf',
                'description' => 'A very good conference about things',
                'url' => 'http://dasconf.org',
                'has_cfp' => false,
            ]);

        $this->assertDatabaseHas(Conference::class, [
            'title' => 'Das Conf',
            'description' => 'A very good conference about things',
            'has_cfp' => false,
        ]);
    }

    /** @test */
    function has_cfp_must_be_a_boolean()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('conferences', [
                'title' => 'Das Conf',
                'description' => 'A very good conference about things',
                'url' => 'http://dasconf.org',
                'has_cfp' => 'yes',
            ]);

        $response->assertSessionHasErrors('has_cfp');
    }

    /** @test */
    function conferences_marked_no_cfp_must_not_include_cfp_fields()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('conferences', [
                'title' => 'Das Conf',
                'description' => 'A very good conference about things',
                'url' => 'http://dasconf.org',
                'starts_at' => Carbon::now()->addDays(2)->toDateString(),
                'ends_at' => Carbon::now()->addDays(3)->toDateString(),
                'has_cfp' => false,
                'cfp_url' => 'https://example.com',
                'cfp_starts_at' => Carbon::now()->toDateString(),
                'cfp_ends_at' => Carbon::now()->addDay()->toDateString(),
            ]);

        $response->assertSessionHasErrors('cfp_url');
        $response->assertSessionHasErrors('cfp_starts_at');
        $response->assertSessionHasErrors('cfp_ends_at');
    }

    /** @test */
    function user_can_edit_conference()
    {
        $user = User::factory()->create();

        $conference = Conference::factory()->author($user)->approved()->create([
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
        $conference = Conference::factory()->author($user)->create();

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

        $conference = Conference::factory()->author($user)->approved()->create([
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
            'cfp_ends_at' => Carbon::now()->subDays(2),
        ]);
        $conferenceB = Conference::factory()->approved()->create([
            'starts_at' => Carbon::now()->addDay(),
            'cfp_ends_at' => Carbon::now(),
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
