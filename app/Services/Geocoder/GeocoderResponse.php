<?php

namespace App\Services\Geocoder;

use App\Casts\Coordinates;

class GeocoderResponse
{
    public function __construct(protected $response)
    {
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

        $values = $country === 'United States'
            ? [$city, $this->getState(), $country]
            : [$city, $country];

        return collect($values)->filter()->implode(', ');
    }

    private function getCoordinate($type)
    {
        return data_get($this->response, "results.0.geometry.location.{$type}");
    }

    private function getCity()
    {
        return $this->getAddressComponent(['locality', 'postal_town'])['long_name'] ?? null;
    }

    private function getState()
    {
        return $this->getAddressComponent(['administrative_area_level_1'])['short_name'] ?? null;
    }

    private function getCountry()
    {
        return $this->getAddressComponent(['country'])['long_name'] ?? null;
    }

    private function getAddressComponent(array $types)
    {
        return collect(data_get($this->response, 'results.0.address_components', []))
            ->firstWhere(fn ($component) => collect($component['types'])->intersect($types)->isNotEmpty());
    }
}
