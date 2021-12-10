<?php

namespace App\Services;

class Geocoder
{
    public function geocode($location)
    {
        return app('geocoder')->geocode($location)->get();
    }
}
