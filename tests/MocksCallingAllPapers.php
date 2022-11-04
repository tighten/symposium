<?php

namespace Tests;

use App\CallingAllPapers\Client;
use App\CallingAllPapers\Event;
use Mockery;
use stdClass;

trait MocksCallingAllPapers
{
    protected $eventId = 'abcdef1234567890abcdef1234567890abcdef122017';

    protected $eventStub;

    public function mockClient($event = null)
    {
        if (! $event) {
            $event = $this->eventStub;
        }

        $mockClient = Mockery::mock(Client::class);

        $mockClient->shouldReceive('getEvents')->andReturn([$event]);
        app()->instance(Client::class, $mockClient);

        return $mockClient;
    }

    public function stubEvent()
    {
        $_rel = new stdClass();
        $_rel->cfp_uri = "v1/cfp/{$this->eventId}";

        $event = new stdClass();

        $event->_rel = $_rel;
        $event->name = 'ABC conference';
        $event->description = 'The greatest conference ever.';
        $event->eventUri = 'https://www.example.com/';
        $event->uri = 'https://cfp.example.com/';
        $event->dateCfpStart = '2017-08-20T00:00:00-04:00';
        $event->dateCfpEnd = '2017-09-22T00:00:00-04:00';
        $event->dateEventStart = '2017-10-20T00:00:00-04:00';
        $event->dateEventEnd = '2017-12-22T00:00:00-04:00';

        $this->eventStub = Event::createFromApiObject($event);
    }
}
