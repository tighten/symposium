<?php

namespace Tests\Console\Commands;

use PHPUnit\Framework\Attributes\Test;
use App\Console\Commands\TweetImportantCFPDates;
use App\Models\Conference;
use Atymic\Twitter\ApiV1\Service\Twitter;
use Carbon\Carbon;
use Tests\TestCase;

final class TweetImportantCFPDatesTest extends TestCase
{
    #[Test]
    public function cfps_opening_today_should_be_tweeted(): void
    {
        // starts today, ends next week
        Conference::factory()->create([
            'cfp_starts_at' => Carbon::now(),
            'cfp_ends_at' => Carbon::now()->addWeek(),
        ]);

        $mock = $this->createMock(Twitter::class);
        $mock->expects($this->once())->method('postTweet');

        (new TweetImportantCFPDates($mock, 0))->handle();
    }

    #[Test]
    public function cfps_closing_tomorrow_should_be_tweeted(): void
    {
        // started last week, ends tomorrow
        Conference::factory()->create([
            'cfp_starts_at' => Carbon::now()->subWeek(),
            'cfp_ends_at' => Carbon::now()->addDay(),
        ]);

        $mock = $this->createMock(Twitter::class);
        $mock->expects($this->once())->method('postTweet');

        (new TweetImportantCFPDates($mock, 0))->handle();
    }

    #[Test]
    public function cfps_not_opening_today_nor_closing_tomorrow_should_not_be_tweeted(): void
    {
        // started last week, ends next week
        Conference::factory()->create([
            'cfp_starts_at' => Carbon::now()->subWeek(),
            'cfp_ends_at' => Carbon::now()->addWeek(),
        ]);

        $mock = $this->createMock(Twitter::class);
        $mock->expects($this->never())->method('postTweet');

        (new TweetImportantCFPDates($mock, 0))->handle();
    }

    #[Test]
    public function cfps_that_open_and_close_same_day_should_not_be_tweeted(): void
    {
        Conference::factory()->create([
            'cfp_starts_at' => Carbon::now(),
            'cfp_ends_at' => Carbon::now(),
        ]);

        $mock = $this->createMock(Twitter::class);
        $mock->expects($this->never())->method('postTweet');

        (new TweetImportantCFPDates($mock, 0))->handle();
    }
}
