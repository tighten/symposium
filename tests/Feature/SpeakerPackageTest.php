<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use App\Casts\SpeakerPackage;
use App\Models\Conference;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class SpeakerPackageTest extends TestCase
{
    #[Test]
    public function speaker_package_can_be_saved_when_conference_is_created(): void
    {
        $user = User::factory()->create();
        $speakerPackage = [
            'currency' => 'usd',
            'travel' => 10,
            'food' => 10,
            'hotel' => 10,
        ];

        $this->followingRedirects()
            ->actingAs($user)
            ->post('conferences', [
                'title' => 'Das Conf',
                'description' => 'A very good conference about things',
                'url' => 'http://dasconf.org',
                'speaker_package' => $speakerPackage,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHasSpeakerPackage($speakerPackage, [
            'title' => 'Das Conf',
            'description' => 'A very good conference about things',
            'url' => 'http://dasconf.org',
        ]);
    }

    #[Test]
    public function speaker_package_can_be_saved_when_conference_is_edited(): void
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

        $this->assertDatabaseHasSpeakerPackage($speakerPackage, [
            'title' => 'My updated conference',
            'description' => 'Conference has been changed a bit.',
        ]);
    }

    #[Test]
    public function speaker_package_can_be_updated(): void
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

        $this->assertDatabaseHasSpeakerPackage($updatedPackage);
    }

    #[Test]
    public function speaker_package_can_be_removed(): void
    {
        $user = User::factory()->create();
        $conference = Conference::factory()
            ->author($user)
            ->withSpeakerPackage()
            ->create();

        $this->actingAs($user)
            ->put("/conferences/{$conference->id}", array_merge($conference->toArray(), [
                'speaker_package' => [],
            ]));

        tap($conference->fresh(), function ($conference) {
            $this->assertNull($conference->speaker_package->currency);
            $this->assertEquals(0, $conference->speaker_package->count());
        });
    }

    #[Test]
    public function decimal_values_are_stored_as_whole_numbers(): void
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

        $conferencePackage = Conference::first()->speaker_package;

        $this->assertEquals(1052, $conferencePackage->travel);
        $this->assertEquals(1575, $conferencePackage->food);
        $this->assertEquals(525, $conferencePackage->hotel);
    }

    #[Test]
    public function values_must_be_valid_currency(): void
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
                'speaker_package' => $speakerPackage,
            ]);

        $this->assertDatabaseMissing(Conference::class, [
            'title' => 'New Conference',
        ]);
    }

    #[Test]
    public function non_us_formats_are_stored_correctly_for_non_us_locale(): void
    {
        App::setLocale('de');

        $user = User::factory()->create();
        $speakerPackage = [
            'currency' => 'eur',
            'food' => '10,00',
            'hotel' => '5,00',
            'travel' => null,
        ];

        $this->followingRedirects()
            ->actingAs($user)
            ->post('conferences', [
                'title' => 'New Conference',
                'description' => 'My new conference',
                'url' => 'https://my-conference.org',
                'speaker_package' => $speakerPackage,
            ])
            ->assertSuccessful();

        $this->assertDatabaseHas(Conference::class, [
            'title' => 'New Conference',
        ]);
    }

    #[Test]
    public function non_us_formats_fail_validation_in_us_locale(): void
    {
        App::setLocale('en');

        $user = User::factory()->create();
        $speakerPackage = [
            'currency' => 'eur',
            'food' => '10,00',
            'hotel' => '5,00',
            'travel' => null,
        ];

        $this->actingAs($user)
            ->post('conferences', [
                'title' => 'New Conference',
                'description' => 'My new conference',
                'url' => 'https://my-conference.org',
                'speaker_package' => $speakerPackage,
            ])
            ->assertInvalid([
                'speaker_package.food',
                'speaker_package.hotel',
            ]);

        $this->assertDatabaseMissing(Conference::class, [
            'title' => 'New Conference',
        ]);
    }

    #[Test]
    public function only_number_values_are_permissible(): void
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
                'speaker_package' => $speakerPackage,
            ]);

        $this->assertDatabaseMissing(Conference::class, [
            'title' => 'New Conference',
        ]);
    }

    private function assertDatabaseHasSpeakerPackage($package, $data = [])
    {
        $this->assertDatabaseHas(Conference::class, array_merge($data, [
            'speaker_package' => json_encode(
                (new SpeakerPackage($package))->toDatabase()
            ),
        ]));
    }
}
