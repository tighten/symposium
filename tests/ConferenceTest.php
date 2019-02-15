<?php

use App\Conference;
use Carbon\Carbon;

class ConferenceTest extends IntegrationTestCase
{
    /** @test */
    function user_can_create_conference()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->visit('/conferences/create')
            ->type('Das Conf', '#title')
            ->type('A very good conference about things', '#description')
            ->type('http://dasconf.org', '#url')
            ->press('Create');

        $this->seeInDatabase('conferences', [
            'title' => 'Das Conf',
            'description' => 'A very good conference about things',
        ]);
    }

    /** @test */
    function user_can_edit_conference()
    {
        $this->disableExceptionHandling();

        $user = factory(App\User::class)->create();

        $conference = factory(App\Conference::class)->create([
            'author_id' => $user->id,
            'title' => 'Rubycon',
            'description' => 'A conference about Ruby',
            'is_approved' => true,
        ]);

        $this->actingAs($user)
            ->visit('/conferences/' . $conference->id . '/edit')
            ->type('Laracon', '#title')
            ->type('A conference about Laravel', '#description')
            ->press('Update');

        $this->seeInDatabase('conferences', [
            'title' => 'Laracon',
            'description' => 'A conference about Laravel',
        ]);

        $this->missingFromDatabase('conferences', [
            'title' => 'Rubycon',
            'description' => 'A conference about Ruby',
        ]);
    }

    /** @test */
    function conferences_accept_proposals_during_the_call_for_papers()
    {
        $conference = factory(App\Conference::class)->create([
            'cfp_starts_at' => Carbon::yesterday(),
            'cfp_ends_at' => Carbon::tomorrow(),
        ]);

        $this->assertTrue($conference->isCurrentlyAcceptingProposals());
    }

    /** @test */
    function conferences_dont_accept_proposals_outside_of_the_call_for_papers()
    {
        $conference = factory(App\Conference::class)->create([
            'cfp_starts_at' => Carbon::tomorrow(),
            'cfp_ends_at' => Carbon::tomorrow()->addDay(),
        ]);

        $this->assertFalse($conference->isCurrentlyAcceptingProposals());

        $conference = factory(App\Conference::class)->create([
            'cfp_starts_at' => Carbon::yesterday()->subDay(),
            'cfp_ends_at' => Carbon::yesterday(),
        ]);

        $this->assertFalse($conference->isCurrentlyAcceptingProposals());
    }

    /** @test */
    function conferences_that_havent_announced_their_cfp_are_not_accepting_proposals()
    {
        $conference = factory(App\Conference::class)->create([
            'cfp_starts_at' => null,
            'cfp_ends_at' => null,
        ]);

        $this->assertFalse($conference->isCurrentlyAcceptingProposals());
    }

    /** @test */
    function non_owners_can_view_conference()
    {
        $user = factory(App\User::class)->create();

        $otherUser = factory(App\User::class)->create();
        $conference = factory(App\Conference::class)->create();
        $otherUser->conferences()->save($conference);

        $this->actingAs($user)
            ->visit('conferences/' . $conference->id)
            ->see($conference->title);
    }

    /** @test */
    function guests_can_view_conference()
    {
        $user = factory(App\User::class)->create();

        $conference = factory(App\Conference::class)->create(['is_approved' => true]);
        $user->conferences()
            ->save($conference);

        $this->visit('conferences/' . $conference->id)
            ->see($conference->title);
    }

    /** @test */
    function guests_can_view_conference_list()
    {
        $user = factory(App\User::class)->create();

        $conference = factory(App\Conference::class)->create(['is_approved' => true]);
        $user->conferences()
            ->save($conference);

        $this->visit('conferences?filter=all')
            ->seePageIs('conferences?filter=all')
            ->see($conference->title);
    }

    /** @test */
    function guests_cannot_create_conference()
    {
        $this->visit('conferences/create')
            ->seePageIs('login');
    }

    /** @test */
    function it_can_pull_only_approved_conferences()
    {
        factory(App\Conference::class)->create();
        factory(App\Conference::class)->create(['is_approved' => true]);

        $this->assertEquals(1, Conference::approved()->count());
    }

    /** @test */
    function it_can_pull_only_not_shared_conferences()
    {
        factory(App\Conference::class)->create();
        factory(App\Conference::class)->create(['is_shared' => true]);

        $this->assertEquals(1, Conference::notShared()->count());
    }

    /** @test */
    function guests_cannot_dismiss_conference()
    {
        $user = Factory::create('user');

        $conference = Factory::build('conference');
        $user->conferences()->save($conference);

        $this->visit("conferences/{$conference->id}/dismiss")
            ->seePageIs('login');
    }

    /** @test */
    function dismissed_conferences_do_not_show_up_in_conference_list()
    {
        $user = Factory::create('user');

        $conference = Factory::build('conference');
        $user->conferences()->save($conference);

        $this->actingAs($user)
            ->visit('conferences?filter=all')
            ->seePageIs('conferences?filter=all')
            ->see($conference->title);

        $this->actingAs($user)
            ->visit("conferences/{$conference->id}/dismiss");

        $this->actingAs($user)
            ->visit('conferences?filter=all')
            ->seePageIs('conferences?filter=all')
            ->dontSee($conference->title);
    }

    /** @test */
    function filtering_by_dismissed_shows_dismissed_conferences()
    {
        $user = Factory::create('user');

        $conference = Factory::build('conference');
        $user->conferences()->save($conference);

        $this->actingAs($user)
            ->visit("conferences/{$conference->id}/dismiss");

        $this->actingAs($user)
            ->visit('conferences?filter=dismissed')
            ->seePageIs('conferences?filter=dismissed')
            ->see($conference->title);
    }

    /** @test */
    function filtering_by_dismissed_does_not_show_undismissed_conferences()
    {
        $user = Factory::create('user');

        $conference = Factory::build('conference');
        $user->conferences()->save($conference);

        $this->actingAs($user)
            ->visit('conferences?filter=dismissed')
            ->seePageIs('conferences?filter=dismissed')
            ->dontSee($conference->title);
    }
}
