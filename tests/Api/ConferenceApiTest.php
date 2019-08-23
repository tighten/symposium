<?php

namespace Tests\Api;

use App\Conference;

class ConferenceApiTest extends ApiTestCase
{
    /** @test */
    function can_fetch_all_conferences()
    {
        $response = $this->call('GET', 'api/conferences');
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsArray($data->data);
    }

    /** @test */
    function can_fetch_one_conference()
    {
        $conferenceId = Conference::first()->id;
        $response = $this->call('GET', 'api/conferences/' . $conferenceId);
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($data->data);
    }

    /** @test */
    function cfp_url_returns_if_set()
    {
        $conference = Conference::create([
            'author_id' => 1,
            'title' => 'AwesomeConf',
            'description' => 'Awesome Conference',
            'url' => 'http://awesome.com',
            'cfp_url' => 'http://awesome.com/cfp',
        ]);
        $response = $this->call('GET', 'api/conferences/' . $conference->id);
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('http://awesome.com/cfp', $data->data->attributes->cfp_url);
    }

    /** @test */
    function cfp_url_returns_null_on_api_if_not_set()
    {
        $conference = Conference::create([
            'author_id' => 1,
            'title' => 'AwesomeConf',
            'description' => 'Awesome Conference',
            'url' => 'http://awesome.com',
        ]);
        $response = $this->call('GET', 'api/conferences/' . $conference->id);
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNull($data->data->attributes->cfp_url);
    }
}
