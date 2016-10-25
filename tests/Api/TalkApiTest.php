<?php

use App\Models\Talk;
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

    public function testAllTalksReturnAlphaSorted()
    {
        $response = $this->call('GET', 'api/user/1/talks');
        $data = collect($this->parseJson($response)->data);

        $titles = $data->pluck('attributes.title');

        $this->assertEquals('My awesome talk', $titles->first());
        $this->assertEquals('My great talk', $titles->last());
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
}
