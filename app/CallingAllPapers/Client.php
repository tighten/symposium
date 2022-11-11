<?php

namespace App\CallingAllPapers;

use App\CallingAllPapers\Event;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\json_decode;

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
