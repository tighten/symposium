<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Talk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TalkReactionsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function creating_a_talk_reaction(): void
    {
        $talk = Talk::factory()->submitted()->create();
        $submission = $talk->submissions->first();

        $response = $this->actingAs($talk->author)
            ->post(route('submissions.reactions.store', $submission), [
                'url' => 'https://example.com',
            ]);

        $response->assertRedirect(route('submission.edit', $submission));
        $this->assertEquals(1, $submission->reactions()->count());
        $this->assertEquals('https://example.com', $submission->reactions->first()->url);
    }

    #[Test]
    public function a_url_is_required_when_creating_a_talk_reaction(): void
    {
        $talk = Talk::factory()->submitted()->create();
        $submission = $talk->submissions->first();

        $response = $this->actingAs($talk->author)
            ->post(route('submissions.reactions.store', $submission));

        $response->assertRedirect();
        $response->assertSessionHasErrors('url');
        $this->assertEquals(0, $submission->reactions()->count());
    }

    #[Test]
    public function a_valid_url_is_required_when_creating_a_talk_reaction(): void
    {
        $talk = Talk::factory()->submitted()->create();
        $submission = $talk->submissions->first();

        $response = $this->actingAs($talk->author)
            ->post(route('submissions.reactions.store', $submission), [
                'url' => 'invalid',
            ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('url');
        $this->assertEquals(0, $submission->reactions()->count());
    }
}
