<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class TalkApiTest extends ApiTestCase
{
    use WithoutMiddleware;

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

        $this->assertEquals(404, $response->getStatusCode());
    }

    // public function testMustBeAuthenticated()
    // {
    //     // @todo: Why is this not bailing out on the auth beforeFilter?
    //     Auth::logout();
    //     $response = $this->call('GET', 'api/user/1/talks');

    //     $this->assertEquals('Invalid credentials.', $response->getContent());
    // }
}
