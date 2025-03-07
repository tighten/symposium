<?php

namespace Tests\Unit;

use App\Models\Conference;
use App\Models\ConferenceIssue;
use App\Models\TightenSlack;
use App\Notifications\ConferenceIssueReported;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ConferenceIssueReportedTest extends TestCase
{
    #[Test]
    public function rendering_the_notification(): void
    {
        $issue = ConferenceIssue::factory()
            ->for(Conference::factory()->create(['title' => 'JediCon']))
            ->create();

        $notification = (new ConferenceIssueReported($issue))
            ->toSlack(new TightenSlack);

        tap(collect($notification->attachments)->first(), function ($attachment) use ($issue) {
            $this->assertNotNull($attachment);
            $this->assertStringContainsString('JediCon', $attachment->title);
            $this->assertStringContainsString("admin/issues/{$issue->id}", $attachment->content);
        });
    }
}
