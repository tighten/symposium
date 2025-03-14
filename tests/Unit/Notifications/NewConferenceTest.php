<?php

namespace Tests\Unit\Notifications;

use App\Models\Conference;
use App\Models\TightenSlack;
use App\Notifications\NewConference;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NewConferenceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function rendering_the_notification(): void
    {
        $conference = Conference::factory()->create(['title' => 'JediCon']);

        $notification = (new NewConference($conference))
            ->toSlack(new TightenSlack);

        tap(collect($notification->attachments)->first(), function ($attachment) {
            $this->assertNotNull($attachment);
            $this->assertStringContainsString('JediCon', $attachment->content);
        });
    }
}
