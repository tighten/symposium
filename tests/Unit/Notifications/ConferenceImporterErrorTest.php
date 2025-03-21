<?php

namespace Tests\Unit\Notifications;

use App\Models\TightenSlack;
use App\Notifications\ConferenceImporterError;
use Exception;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ConferenceImporterErrorTest extends TestCase
{
    #[Test]
    public function rendering_the_notification(): void
    {
        $notification = (new ConferenceImporterError(new Exception('Test exception')))
            ->toSlack(new TightenSlack);

        tap(collect($notification->attachments)->first(), function ($attachment) {
            $this->assertNotNull($attachment);
            $this->assertStringContainsString('Test exception', $attachment->content);
        });
    }
}
