<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class ConferenceApiTest extends ApiTestCase
{
    use WithoutMiddleware;

    public function testFetchesAllConferences()
    {
        $response = $this->call('GET', 'api/conferences');
        $data = $this->parseJson($response);

        $this->assertIsJson($data);
        $this->assertInternalType('array', $data->data);
    }

    public function testFetchesOneConference()
    {
        $bioId = Conference::first()->id;
        $response = $this->call('GET', 'api/conferences/' . $bioId);
        $data = $this->parseJson($response);

        $this->assertIsJson($data);
        $this->assertInternalType('object', $data->data);
    }
}
