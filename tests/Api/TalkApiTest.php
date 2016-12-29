<?php

use App\Talk;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laracasts\TestDummy\Factory;

class TalkApiTest extends ApiTestCase
{
    use WithoutMiddleware;

    /** @test */
    function fetches_all_talks_for_user()
    {
        $response = $this->call('GET', 'api/user/1/talks');
        $data = $this->parseJson($response);

        $this->assertIsJson($data);
        $this->assertInternalType('array', $data->data);
        $this->assertCount(2, $data->data);
    }

    /** @test */
    function all_talks_doesnt_return_archived_talks()
    {
        $author = User::first();

        $toBeArchivedTalk = $author->talks()->create([]);

        $toBeArchivedTalk->revisions()->save(Factory::create('talkRevision'));

        $response = $this->call('GET', 'api/user/1/talks');
        $data = $this->parseJson($response);

        $this->assertCount(3, $data->data);

        $toBeArchivedTalk->archive();

        $response = $this->call('GET', 'api/user/1/talks');
        $data = $this->parseJson($response);

        $this->assertCount(2, $data->data);
    }

    /** @test */
    function all_talks_return_alpha_sorted()
    {
        $response = $this->call('GET', 'api/user/1/talks');
        $data = collect($this->parseJson($response)->data);

        $titles = $data->pluck('attributes.title');

        $this->assertEquals('My awesome talk', $titles->first());
        $this->assertEquals('My great talk', $titles->last());
    }

    /** @test */
    function fetches_one_talk()
    {
        $talkId = Talk::first()->id;
        $response = $this->call('GET', 'api/talks/' . $talkId);
        $data = $this->parseJson($response);

        $this->assertIsJson($data);
        $this->assertInternalType('object', $data->data);
    }

    /** @test */
    function cannot_fetch_all_talks_for_other_users()
    {
        $response = $this->call('GET', 'api/user/2/talks');
        $this->assertEquals(404, $response->getStatusCode());
    }

    /** @test */
    function cannot_fetch_one_talk_for_other_users()
    {
        $talkId = Talk::where('author_id', 2)->first()->id;

        $response = $this->call('GET', 'api/talks/' . $talkId);

        $this->assertEquals(404, $response->getStatusCode());
    }
}
