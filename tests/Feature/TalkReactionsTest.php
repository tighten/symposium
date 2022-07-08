<?php

namespace Tests\Feature;

use App\Models\Talk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TalkReactionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function creating_a_talk_reaction()
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

    /** @test */
    function a_url_is_required_when_creating_a_talk_reaction()
    {
        $talk = Talk::factory()->submitted()->create();
        $submission = $talk->submissions->first();

        $response = $this->actingAs($talk->author)
            ->post(route('submissions.reactions.store', $submission));

        $response->assertRedirect();
        $response->assertSessionHasErrors('url');
        $this->assertEquals(0, $submission->reactions()->count());
    }

    /** @test */
    function a_valid_url_is_required_when_creating_a_talk_reaction()
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
