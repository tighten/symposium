<?php

namespace App\CallingAllPapers;

use Illuminate\Support\Facades\Http;

class Client
{
    public function getEvents()
    {
        return collect(json_decode($this->get())->cfps)->map(function ($cfpFromApi) {
            return Event::createFromApiObject($cfpFromApi);
        });
    }

    private function get()
    {
        return Http::withHeaders(['User-Agent' => 'Symposium CLI'])
            ->get('https://api.callingallpapers.com/v1/cfp')
            ->getBody()
            ->getContents();
    }
}
