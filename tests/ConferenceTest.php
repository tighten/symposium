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
}
