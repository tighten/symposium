<?php

namespace App\CallingAllPapers;

use GuzzleHttp\Client as GuzzleClient;

class Client
{
    private $guzzle;

    public function __construct(GuzzleClient $client)
    {
        $this->guzzle = $client;
    }

    public function getEvents()
    {
        return collect($this->get('')->cfps)->map(function ($cfpFromApi) {
            return Event::createFromApiObject($cfpFromApi);
        });
    }

    private function get($path)
    {
        return json_decode($this->guzzle->get($path)->getBody()->getContents());
    }
}
