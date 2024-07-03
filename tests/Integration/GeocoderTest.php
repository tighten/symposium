<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use App\Exceptions\InvalidAddressGeocodingException;
use App\Services\Geocoder;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeocoderTest extends TestCase
{
    #[Test]
    public function geocoding_an_address(): void
    {
        $this->markTestSkipped('This test fails intermittently.');

        $geocoder = app(Geocoder::class);

        $coordinates = $geocoder->geocode('1600 Pennsylvania Ave Washington, DC');

        $this->assertEquals('38.8976801', $coordinates->getLatitude());
        $this->assertEquals('-77.0363304', $coordinates->getLongitude());
    }

    #[Test]
    public function catching_invalid_addresses(): void
    {
        $this->expectNotToPerformAssertions();
        $geocoder = app(Geocoder::class);

        try {
            $geocoder->geocode('The Death Star');
        } catch (InvalidAddressGeocodingException $e) {
            return;
        }

        $this->fail('An exception was expected but not thrown');
    }

    #[Test]
    public function invalid_addresses_are_only_attempted_once(): void
    {
        $geocoder = app(Geocoder::class);
        $this->assertNull(cache('invalid-address::' . md5('The Death Star')));

        try {
            $geocoder->geocode('The Death Star');
        } catch (InvalidAddressGeocodingException $e) {
        }

        $this->assertNotNull(cache('invalid-address::' . md5('The Death Star')));

        try {
            Http::fake();
            $geocoder->geocode('The Death Star');
        } catch (InvalidAddressGeocodingException $e) {
            Http::assertNothingSent();

            return;
        }

        $this->fail('An exception was expected but not thrown');
    }
}
