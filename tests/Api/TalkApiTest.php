<?php

use App\Talk;
use Laracasts\TestDummy\Factory;

class TalkApiTest extends ApiTestCase
{
    /** @test */
    function can_fetch_all_talks_for_user()
    {
        $response = $this->call('GET', 'api/user/1/talks');
        $data = json_decode($response->getContent());

        $this->assertInternalType('array', $data->data);
        $this->assertCount(2, $data->data);
    }

    /** @test */
    function all_talks_doesnt_return_archived_talks()
    {
        $toBeArchivedTalk = $this->user->talks()->create([]);
        $toBeArchivedTalk->revisions()->save(Factory::create('talkRevision'));

        $response = $this->call('GET', 'api/user/1/talks');
        $data = json_decode($response->getContent());

        $this->assertCount(3, $data->data);

        $toBeArchivedTalk->archive();

        $response = $this->call('GET', 'api/user/1/talks');
        $data = json_decode($response->getContent());

        $this->assertCount(2, $data->data);
    }

    /** @test */
    function all_talks_return_alpha_sorted()
    {
        $response = $this->call('GET', 'api/user/1/talks');
        $data = collect(json_decode($response->getContent())->data);

        $titles = $data->pluck('attributes.title');

        $this->assertEquals('My awesome talk', $titles->first());
        $this->assertEquals('My great talk', $titles->last());
    }

    /** @test */
    function can_fetch_one_talk()
    {
        $talkId = Talk::first()->id;
        $response = $this->call('GET', 'api/talks/' . $talkId);
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
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
