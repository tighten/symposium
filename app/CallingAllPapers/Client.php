<?php

namespace App\CallingAllPapers;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\json_decode;

class Client
{
    private $guzzle;

    public function __construct(GuzzleClient $client = null)
    {
        $this->guzzle = $client ?: new GuzzleClient([
            'headers'  => ['User-Agent' => 'Symposium CLI'],
            'base_uri' => 'https://api.callingallpapers.com/v1/cfp',
        ]);
    }

    private function get($path)
    {
        return json_decode($this->guzzle->get($path)->getBody()->getContents());
    }

    public function getEvents()
    {
        return collect($this->get('')->cfps)->map(function ($cfp) {
            return Event::createFromStdClass($cfp);
        });
    }
}
