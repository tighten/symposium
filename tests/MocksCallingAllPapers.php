<?php

namespace Tests;

use App\CallingAllPapers\Client;
use App\CallingAllPapers\Event;
use Exception;
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

    public function mockClientWithError()
    {
        $mockClient = Mockery::mock(Client::class);

        $mockClient->shouldReceive('getEvents')
            ->andThrow(Exception::class, 'Test exception');
        app()->instance(Client::class, $mockClient);

        return $mockClient;
    }

    public function stubEvent(array $overrides = [])
    {
        $_rel = new stdClass;
        $_rel->cfp_uri = "v1/cfp/{$this->eventId}";

        $event = new stdClass;

        $raw = array_merge($this->rawEvent(), $overrides);

        $event->_rel = $_rel;
        $event->name = $raw['name'];
        $event->description = $raw['description'];
        $event->eventUri = $raw['eventUri'];
        $event->uri = $raw['uri'];
        $event->dateCfpStart = $raw['dateCfpStart'];
        $event->dateCfpEnd = $raw['dateCfpEnd'];
        $event->dateEventStart = $raw['dateEventStart'];
        $event->dateEventEnd = $raw['dateEventEnd'];

        $this->eventStub = Event::createFromApiObject($event);
    }

    public function rawEvent()
    {
        return [
            'name' => 'ABC conference',
            'description' => 'The greatest conference ever.',
            'eventUri' => 'https://www.example.com/',
            'uri' => 'https://cfp.example.com/',
            'dateCfpStart' => '2017-08-20T00:00:00-04:00',
            'dateCfpEnd' => '2017-09-22T00:00:00-04:00',
            'dateEventStart' => '2017-10-20T00:00:00-04:00',
            'dateEventEnd' => '2017-12-22T00:00:00-04:00',
        ];
    }
}
