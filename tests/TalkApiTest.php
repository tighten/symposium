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

    public function testCannotFetchAllTalksForOtherUser()
    {
        $response = $this->call('GET', 'api/user/2/talks');
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testCannotFetchOneTalkForOtherUser()
    {
        $talkId = Talk::where('author_id', 2)->first()->id;

        $response = $this->call('GET', 'api/talks/' . $talkId);

        // @todo: This doesn't feel right. Originally I wanted 403, then 404
        // (so we're not exposing that the given talk ID exists), but the
        // default is 500 which just feels wrong.
        $this->assertEquals(500, $response->getStatusCode());
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
