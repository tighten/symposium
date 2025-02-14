<?php

namespace App\CallingAllPapers;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Http;

class Client
{
    private $guzzle;

    public function __construct(GuzzleClient $client)
    {
        $this->guzzle = $client;
    }

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
