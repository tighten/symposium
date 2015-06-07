<?php

class ConferenceApiTest extends ApiTestCase
{
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
