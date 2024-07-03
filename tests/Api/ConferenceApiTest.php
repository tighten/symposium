<?php

namespace Tests\Api;

use PHPUnit\Framework\Attributes\Test;
use App\Models\Conference;

final class ConferenceApiTest extends ApiTestCase
{
    #[Test]
    public function can_fetch_all_conferences(): void
    {
        $response = $this->call('GET', 'api/conferences');
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsArray($data->data);
    }

    #[Test]
    public function can_fetch_one_conference(): void
    {
        $conferenceId = Conference::first()->id;
        $response = $this->call('GET', "api/conferences/{$conferenceId}");
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($data->data);
    }

    #[Test]
    public function cfp_url_returns_if_set(): void
    {
        $conference = Conference::create([
            'author_id' => 1,
            'title' => 'AwesomeConf',
            'description' => 'Awesome Conference',
            'url' => 'http://awesome.com',
            'cfp_url' => 'http://awesome.com/cfp',
        ]);
        $response = $this->call('GET', "api/conferences/{$conference->id}");
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('http://awesome.com/cfp', $data->data->attributes->cfp_url);
    }

    #[Test]
    public function cfp_url_returns_null_on_api_if_not_set(): void
    {
        $conference = Conference::create([
            'author_id' => 1,
            'title' => 'AwesomeConf',
            'description' => 'Awesome Conference',
            'url' => 'http://awesome.com',
        ]);
        $response = $this->call('GET', "api/conferences/{$conference->id}");
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNull($data->data->attributes->cfp_url);
    }

    #[Test]
    public function unclosed_cfp_returns_open_and_future_cfp(): void
    {
        Conference::factory()
            ->cfpDates(now()->subDay(), now()->addDay())
            ->create(['title' => 'Open CFP']);
        Conference::factory()
            ->cfpDates(now()->addDay(), now()->addDays(2))
            ->create(['title' => 'Future CFP']);

        $response = $this->call('GET', 'api/conferences?filter=unclosed_cfp');

        $response->assertJsonFragment(['title' => 'Open CFP']);
        $response->assertJsonFragment(['title' => 'Future CFP']);
    }
}
