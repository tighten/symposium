<?php

namespace App\Console\Commands;

use App\Exceptions\InvalidAddressGeocodingException;
use App\Models\Conference;
use App\Services\Geocoder;
use Illuminate\Console\Command;

class BackfillConferenceLocationNames extends Command
{
    protected $signature = 'app:backfill-conference-location-names';

    protected $description = 'Command description';

    public function handle()
    {
        $conferences = Conference::query()
            ->whereAfter(now())
            ->whereNotNull(['latitude', 'longitude'])
            ->whereNull('location_name')
            ->get();

        $conferences->each(function ($conference) {
            try {
                $result = app(Geocoder::class)->geocode($conference->location);
            } catch (InvalidAddressGeocodingException $e) {
                return;
            }

            $conference->location_name = $result->getLocationName();
            $conference->save();
        });

        dd($conferences->count());
    }
}
