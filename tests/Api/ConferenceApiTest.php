<?php

use App\Models\Conference;
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
        $conferenceId = Conference::first()->id;
        $response = $this->call('GET', 'api/conferences/' . $conferenceId);
        $data = $this->parseJson($response);

        $this->assertIsJson($data);
        $this->assertInternalType('object', $data->data);
    }

    public function testCfpUrlReturnsIfSet()
    {
        $conference = Conference::create([
            'author_id' => 1,
            'title' => 'AwesomeConf',
            'description' => 'Awesome Conference',
            'url' => 'http://awesome.com',
            'cfp_url' => 'http://awesome.com/cfp'
        ]);
        $response = $this->call('GET', 'api/conferences/' . $conference->id);
        $data = $this->parseJson($response);

        $this->assertEquals('http://awesome.com/cfp', $data->data->attributes->cfp_url);
    }

    public function testCfpUrlReturnsNullOnApiIfNotSet()
    {
        $conference = Conference::create([
            'author_id' => 1,
            'title' => 'AwesomeConf',
            'description' => 'Awesome Conference',
            'url' => 'http://awesome.com'
        ]);
        $response = $this->call('GET', 'api/conferences/' . $conference->id);
        $data = $this->parseJson($response);

        $this->assertNull($data->data->attributes->cfp_url);
    }
}
