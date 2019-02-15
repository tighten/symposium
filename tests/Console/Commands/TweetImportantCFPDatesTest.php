<?php

use Mockery as m;
use Carbon\Carbon;
use Thujohn\Twitter\Twitter;
use App\Console\Commands\TweetImportantCFPDates;

class TweetImportantCFPDatesTest extends IntegrationTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->twitter = m::mock(Twitter::class);
    }

    /** @test */
    public function cfps_opening_today_should_be_tweeted()
    {
        // starts today, ends next week
        factory(App\Conference::class)->create([
            'cfp_starts_at' => Carbon::now(),
            'cfp_ends_at' => Carbon::now()->addWeek()
        ]);

        $this->twitter->shouldReceive('postTweet')->once();

        (new TweetImportantCFPDates($this->twitter, 0))->fire();
    }

    /** @test */
    public function cfps_closing_tomorrow_should_be_tweeted()
    {
        // started last week, ends tomorrow
        factory(App\Conference::class)->create([
            'cfp_starts_at' => Carbon::now()->subWeek(),
            'cfp_ends_at' => Carbon::now()->addDay()
        ]);

        $this->twitter->shouldReceive('postTweet')->once();

        (new TweetImportantCFPDates($this->twitter, 0))->fire();
    }

    /** @test */
    public function cfps_not_opening_today_nor_closing_tomorrow_should_not_be_tweeted()
    {
        // started last week, ends next week
        factory(App\Conference::class)->create([
            'cfp_starts_at' => Carbon::now()->subWeek(),
            'cfp_ends_at' => Carbon::now()->addWeek(),
        ]);

        $this->twitter->shouldNotReceive('postTweet');

        (new TweetImportantCFPDates($this->twitter, 0))->fire();
    }

    /** @test */
    public function cfps_that_open_and_close_same_day_should_not_be_tweeted()
    {
        factory(App\Conference::class)->create([
            'cfp_starts_at' => Carbon::now(),
            'cfp_ends_at' => Carbon::now(),
        ]);

        $this->twitter->shouldNotReceive('postTweet');

        (new TweetImportantCFPDates($this->twitter, 0))->fire();
    }
}
