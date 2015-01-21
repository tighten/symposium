<?php

use Laracasts\TestDummy\Factory;
use Carbon\Carbon;

class ConferenceTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    /** @test */
    public function conferences_accept_proposals_during_the_call_for_papers()
    {
        $conference = Factory::create('conference', [
            'cfp_starts_at' => Carbon::yesterday(),
            'cfp_ends_at' => Carbon::tomorrow(),
        ]);

        $this->assertTrue($conference->isCurrentlyAcceptingProposals());
    }

    /** @test */
    public function conferences_dont_accept_proposals_outside_of_the_call_for_papers()
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
    public function conferences_that_havent_announced_their_cfp_are_not_accepting_proposals()
    {
        $conference = Factory::create('conference', [
            'cfp_starts_at' => null,
            'cfp_ends_at' => null,
        ]);

        $this->assertFalse($conference->isCurrentlyAcceptingProposals());
    }
}
