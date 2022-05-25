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
                'url' => 'example.com',
            ]);

        $response->assertSuccessful();
        $this->assertEquals(1, $submission->reactions()->count());
        $this->assertEquals('example.com', $submission->reactions->first()->url);
    }
}
