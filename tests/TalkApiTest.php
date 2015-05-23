<?php

class TalkApiTest extends ApiTestCase
{
    public function testFetchesAllTalksForUser()
    {
        $response = $this->call('GET', 'api/user/1/talks');
        $data = $this->parseJson($response);

        $this->assertIsJson($data);
        $this->assertInternalType('array', $data->data);
    }

    public function testFetchesOneTalk()
    {
        $talkId = Talk::first()->id;
        $response = $this->call('GET', 'api/talks/' . $talkId);
        $data = $this->parseJson($response);

        $this->assertIsJson($data);
        $this->assertInternalType('object', $data->data);
    }

    // public function testMustBeAuthenticated()
    // {
    //     // @todo: Why is this not bailing out on the auth beforeFilter?
    //     Auth::logout();
    //     $response = $this->call('GET', 'api/user/1/talks');

    //     $this->assertEquals('Invalid credentials.', $response->getContent());
    // }

    protected function parseJson($response)
    {
        return json_decode($response->getContent());
    }

    protected function assertIsJson($data)
    {
        $this->assertEquals(0, json_last_error(), 'Return is not JSON');
    }
}
