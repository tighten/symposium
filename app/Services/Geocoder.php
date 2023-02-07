<?php

namespace App\Services;

use App\Casts\Coordinates;
use App\Exceptions\InvalidAddressGeocodingException;
use Illuminate\Support\Facades\Http;

class Geocoder
{
    public function geocode(string $address)
    {
        if ($this->isInvalidAddress($address)) {
            throw new InvalidAddressGeocodingException();
        }

        $response = $this->requestGeocoding($address);

        if (! count($response['results'])) {
            cache()->set('invalid-address::' . md5($address), true);
            throw new InvalidAddressGeocodingException();
        }

        return new Coordinates(
            $this->getCoordinate('lat', $response),
            $this->getCoordinate('lng', $response),
        );
    }

    private function requestGeocoding($address)
    {
        return Http::acceptJson()
            ->withHeaders([
                'User-Agent' => 'Symposium CLI',
            ])
            ->get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $address,
                'key' => config('services.google.maps.key'),
            ])
            ->json();
    }

    private function getCoordinate($type, $response)
    {
        return data_get($response, "results.0.geometry.location.{$type}");
    }

    private function isInvalidAddress($address)
    {
        return cache('invalid-address::' . md5($address));
    }
}
