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
            'speaker_package' => $this->getFormattedSpeakerPackageValues($speakerPackage),
        ]);
    }

    /** @test */
    public function speaker_package_can_be_saved_when_conference_is_edited()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()
            ->author($user)
            ->approved()
            ->create([
                'title' => 'My Conference',
                'description' => 'A conference that I made.',
            ]);
        $speakerPackage = [
            'currency' => 'usd',
            'travel' => 10.00,
            'food' => 10.00,
            'hotel' => 10.00,
        ];

        $this->actingAs($user)
            ->put("/conferences/{$conference->id}", array_merge($conference->toArray(), [
                'title' => 'My updated conference',
                'description' => 'Conference has been changed a bit.',
                'speaker_package' => $speakerPackage,
            ]));

        $this->assertDatabaseHas(Conference::class, [
            'speaker_package' => $this->getFormattedSpeakerPackageValues($speakerPackage),
        ]);
    }

    /** @test */
    public function speaker_package_can_be_updated()
    {
        $user = User::factory()->create();
        $conference = Conference::factory()
            ->author($user)
            ->withSpeakerPackage()
            ->create();

        // Factory sets values to 10 by default
        $updatedPackage = [
            'currency' => 'usd',
            'travel' => 5,
            'food' => 10.00,
            'hotel' => 20,
        ];

        $this->actingAs($user)
            ->put("/conferences/{$conference->id}", array_merge($conference->toArray(), [
                'speaker_package' => $updatedPackage,
            ]));

        $this->assertDatabaseHas(Conference::class, [
            'speaker_package' => $this->getFormattedSpeakerPackageValues($updatedPackage),
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

    public function getFormattedSpeakerPackageValues($package)
    {
        $speakerPackage = [
            'currency' => $package['currency'],
        ];

        $speakerPackage['travel'] = round($package['travel'], 2) * 100;
        $speakerPackage['food'] = round($package['food'], 2) * 100;
        $speakerPackage['hotel'] = round($package['hotel'], 2) * 100;

        return json_encode($speakerPackage);
    }
}
