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
            $this->getCoordinate('lat'),
            $this->getCoordinate('lng'),
        );
    }

    public function getLocationName(): string
    {
        $country = $this->getCountry();
        $city = $this->getCity();

        if ($country === 'United States') {
            $state = $this->getState();
            return "{$city}, {$state}, {$country}";
        }

        return "{$city}, {$country}";
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

    private function getCoordinate($type)
    {
        return data_get($this->response, "results.0.geometry.location.{$type}");
    }

    private function getCity()
    {
        return $this->getAddressComponent(['locality', 'postal_town'])['long_name'] ?? '';
    }

    private function getState()
    {
        return $this->getAddressComponent(['administrative_area_level_1'])['short_name'] ?? '';
    }

    private function getCountry()
    {
        return $this->getAddressComponent(['country'])['long_name'] ?? '';
    }

    private function getAddressComponent(array $types)
    {
        return collect(data_get($this->response, 'results.0.address_components', []))
            ->firstWhere(fn ($component) => collect($component['types'])->intersect($types)->isNotEmpty());
    }

    private function isInvalidAddress($address)
    {
        return cache('invalid-address::' . md5($address));
    }
}
