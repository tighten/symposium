<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\User;
use Cknow\Money\Money;
use Illuminate\Support\Str;
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

    /** @test */
    public function values_must_be_valid_currency()
    {
        $user = User::factory()->create();
        $speakerPackage = [
            'currency' => 'invalid-currency',
            'travel' => 10,
            'food' => 10,
            'hotel' => 10,
        ];

        $this->actingAs($user)
            ->post('conferences', [
                'title' => 'New Conference',
                'description' => 'My new conference',
                'url' => 'https://my-conference.org',
                'speaker_package' => $speakerPackage

            ]);

        $this->assertDatabaseMissing(Conference::class, [
            'title' => 'New Conference',
        ]);
    }

    /** @test */
    public function non_us_formats_are_stored_correctly()
    {
        $user = User::factory()->create();
        $speakerPackage = [
            'currency' => 'eur',
            'travel' => 1.033, 00,
            'food' => 10, 00,
            'hotel' => 5, 00,
        ];

        $this->actingAs($user)
            ->post('conferences', [
                'title' => 'New Conference',
                'description' => 'My new conference',
                'url' => 'https://my-conference.org',
                'speaker_package' => $speakerPackage

            ]);

        $this->assertDatabaseHas(Conference::class, [
            'title' => 'New Conference',
        ]);
    }

    /** @test */
    public function only_number_values_are_permissible()
    {
        $user = User::factory()->create();
        $speakerPackage = [
            'currency' => 'usd',
            'travel' => '10.',
            'food' => '10.?',
            'hotel' => 'no-letters',
        ];

        $this->actingAs($user)
            ->post('conferences', [
                'title' => 'New Conference',
                'description' => 'My new conference',
                'url' => 'https://my-conference.org',
                'speaker_package' => $speakerPackage

            ]);

        $this->assertDatabaseMissing(Conference::class, [
            'title' => 'New Conference',
        ]);
    }

    public function getFormattedSpeakerPackageValues($package)
    {
        $speakerPackage = [
            'currency' => $package['currency'],
        ];

        // Since users have the ability to enter punctuation or not, then we want to 
        // use the appropriate parser
        $travelHasPunctuation = Str::of($package['travel'])->contains([',', '.']);
        $hotelHasPunctuation = Str::of($package['hotel'])->contains([',', '.']);
        $foodHasPunctuation = Str::of($package['food'])->contains([',', '.']);


        $speakerPackage['travel'] = Money::parse($package['travel'], $package['currency'], !$travelHasPunctuation)->getAmount();
        $speakerPackage['food'] = Money::parse($package['food'], $package['currency'], !$foodHasPunctuation)->getAmount();
        $speakerPackage['hotel'] = Money::parse($package['hotel'], $package['currency'], !$hotelHasPunctuation)->getAmount();

        return json_encode($speakerPackage);
    }
}
