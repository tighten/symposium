<?php

namespace App\Services;

use App\Casts\Coordinates;
use App\Exceptions\InvalidAddressGeocodingException;
use Illuminate\Support\Facades\Http;

class Geocoder
{
    private $response;

    public function geocode(string $address): self
    {
        if ($this->isInvalidAddress($address)) {
            throw new InvalidAddressGeocodingException;
        }

        $this->response = $this->requestGeocoding($address);

        if (! count($this->response['results'])) {
            cache()->set('invalid-address::' . md5($address), true);
            throw new InvalidAddressGeocodingException;
        }

        return $this;
    }

    public function getCoordinates(): Coordinates
    {
        return new Coordinates(
            $this->getCoordinate('lat', $this->response),
            $this->getCoordinate('lng', $this->response),
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
