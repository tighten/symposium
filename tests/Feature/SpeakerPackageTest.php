<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SpeakerPackageTest extends TestCase
{
    /** @test */
    public function speaker_package_is_saved_when_conference_is_created()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $speakerPackage = [
            'currency' => 'usd',
            'travel' => 10,
            'food' => 10,
            'hotel' => 10,
        ];

        $this->actingAs($user)
            ->post('conferences', [
                'title' => 'Das Conf',
                'description' => 'A very good conference about things',
                'url' => 'http://dasconf.org',
                'speaker_package' => $speakerPackage,

            ]);

        $this->assertDatabaseHas(Conference::class, [
            'speaker_package' => json_encode($speakerPackage),
        ]);
    }
}
