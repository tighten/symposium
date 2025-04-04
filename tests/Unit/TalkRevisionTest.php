<?php

namespace Tests\Unit;

use App\Models\TalkRevision;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TalkRevisionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function missing_descriptions_and_organizer_notes_are_displayed_as_empty(): void
    {
        $revision = TalkRevision::factory()->create([
            'description' => '',
            'organizer_notes' => '',
        ]);

        $this->assertEquals('<i>(empty)</i>', $revision->getDescription());
        $this->assertEquals('<i>(empty)</i>', $revision->getHtmledOrganizerNotes());
    }
}
