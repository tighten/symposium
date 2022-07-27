<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\User;
use Tests\TestCase;

class SpeakerPackageTest extends TestCase
{
    /** @test */
    public function speaker_package_can_be_saved_when_conference_is_created()
    {
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

    /** @test */
    public function decimal_values_are_stored_as_whole_numbers()
    {
        $user = User::factory()->create();
        $speakerPackage = [
            'currency' => 'usd',
            'travel' => 10.520,
            'food' => 15.75,
            'hotel' => 5.25,
        ];

        $this->actingAs($user)
            ->post('conferences', [
                'title' => 'Das Conf',
                'description' => 'A very good conference about things',
                'url' => 'http://dasconf.org',
                'speaker_package' => $speakerPackage,

            ]);

        $conferencePackage = json_decode(Conference::first()->speaker_package);

        $this->assertEquals(1052, $conferencePackage->travel);
        $this->assertEquals(1575, $conferencePackage->food);
        $this->assertEquals(525, $conferencePackage->hotel);
    }
}
