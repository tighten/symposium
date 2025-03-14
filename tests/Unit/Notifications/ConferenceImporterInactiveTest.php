<?php

namespace Tests\Unit\Notifications;

use App\Models\TightenSlack;
use App\Notifications\ConferenceImporterInactive;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ConferenceImporterInactiveTest extends TestCase
{
    #[Test]
    public function rendering_the_notification(): void
    {
        cache(['conference_importer_last_ran_at' => '2024-05-04 11:11:11']);

        $notification = (new ConferenceImporterInactive)
            ->toSlack(new TightenSlack);

        tap(collect($notification->attachments)->first(), function ($attachment) {
            $this->assertNotNull($attachment);
            $this->assertStringContainsString('2024-05-04 11:11:11', $attachment->content);
        });
    }
}
