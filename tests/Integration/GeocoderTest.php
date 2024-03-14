<?php

namespace Tests\Feature;

use App\Exceptions\InvalidAddressGeocodingException;
use App\Services\Geocoder;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeocoderTest extends TestCase
{
    /** @test */
    function geocoding_an_address()
    {
        $geocoder = app(Geocoder::class);

        $coordinates = $geocoder->geocode('1600 Pennsylvania Ave Washington, DC');

        $this->assertEquals('38.8976801', $coordinates->getLatitude());
        $this->assertEquals('-77.0363304', $coordinates->getLongitude());
    }

    /** @test */
    function catching_invalid_addresses()
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

    /** @test */
    function invalid_addresses_are_only_attempted_once()
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
