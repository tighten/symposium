<?php

use App\Conference;
use Carbon\Carbon;
use Laracasts\TestDummy\Factory;

class ConferenceTest extends IntegrationTestCase
{
    /** @test */
    function user_can_create_conference()
    {
        $user = Factory::create('user');

        $this->actingAs($user)
            ->visit('/conferences/create')
            ->type('Das Conf', '#title')
            ->type('A very good conference about things', '#description')
            ->type('http://dasconf.org', '#url')
            ->press('Create');

        $this->seeInDatabase('conferences',[
            'title' => 'Das Conf',
            'description' => 'A very good conference about things',
        ]);
    }

    /** @test */
    function user_can_edit_conference()
    {
        $this->disableExceptionHandling();

        $user = Factory::create('user');

        $conference = Factory::create('conference', [
            'author_id' => $user->id,
            'title' => 'Rubycon',
            'description' => 'A conference about Ruby',
        ]);

        $this->actingAs($user)
            ->visit('/conferences/' . $conference->id . '/edit')
            ->type('Laracon', '#title')
            ->type('A conference about Laravel', '#description')
            ->press('Update');

        $this->seeInDatabase('conferences',[
            'title' => 'Laracon',
            'description' => 'A conference about Laravel',
        ]);

        $this->missingFromDatabase('conferences',[
            'title' => 'Rubycon',
            'description' => 'A conference about Ruby',
        ]);
    }
    /** @test */
    function conferences_accept_proposals_during_the_call_for_papers()
    {
        $conference = Factory::create('conference', [
            'cfp_starts_at' => Carbon::yesterday(),
            'cfp_ends_at' => Carbon::tomorrow(),
        ]);

        $this->assertTrue($conference->isCurrentlyAcceptingProposals());
    }

    /** @test */
    function conferences_dont_accept_proposals_outside_of_the_call_for_papers()
    {
        $conference = Factory::create('conference', [
            'cfp_starts_at' => Carbon::tomorrow(),
            'cfp_ends_at' => Carbon::tomorrow()->addDay(),
        ]);

        $this->assertFalse($conference->isCurrentlyAcceptingProposals());

        $conference = Factory::create('conference', [
            'cfp_starts_at' => Carbon::yesterday()->subDay(),
            'cfp_ends_at' => Carbon::yesterday(),
        ]);

        $this->assertFalse($conference->isCurrentlyAcceptingProposals());
    }

    /** @test */
    function conferences_that_havent_announced_their_cfp_are_not_accepting_proposals()
    {
        $conference = Factory::create('conference', [
            'cfp_starts_at' => null,
            'cfp_ends_at' => null,
        ]);

        $this->assertFalse($conference->isCurrentlyAcceptingProposals());
    }

    /** @test */
    function non_owners_can_view_conference()
    {
        $user = Factory::create('user');

        $otherUser = Factory::create('user');
        $conference = Factory::build('conference');
        $otherUser->conferences()->save($conference);

        $this->actingAs($user)
            ->visit('conferences/' . $conference->id)
            ->see($conference->title);
    }

    /** @test */
    function guests_can_view_conference()
    {
        $user = Factory::create('user');

        $conference = Factory::build('conference');
        $user->conferences()->save($conference);

        $this->visit('conferences/' . $conference->id)
            ->see($conference->title);
    }

    /** @test */
    function guests_can_view_conference_list()
    {
        $user = Factory::create('user');

        $conference = Factory::build('conference');
        $user->conferences()->save($conference);

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
}
