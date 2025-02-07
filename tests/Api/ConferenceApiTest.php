<?php

namespace Tests\Api;

use App\Models\Conference;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ConferenceApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Passport::actingAs($this->user);
    }

    #[Test]
    public function can_fetch_all_conferences(): void
    {
        $response = $this->call('GET', 'api/conferences');
        $data = json_decode($response->getContent());
    }

    #[Test]
    public function conference_index_defaults_to_cfp_unclosed_conferences()
    {
        $closedCfpConference = Conference::factory()
            ->cfpDates(now()->subDays(2), now()->subDays(1))
            ->create();
        $unClosedCfpConference = Conference::factory()
            ->cfpDates(now()->addDay(), now()->addDays(2))
            ->create();

        $response = $this->call('GET', 'api/conferences');

        $response->assertSuccessful();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.id', $unClosedCfpConference->id);
    }

    #[Test]
    public function fetching_all_conferences()
    {
        $conference = Conference::factory()->create();

        $response = $this->call('GET', 'api/conferences?filter=all');

        $response->assertSuccessful();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.id', $conference->id);
    }

    #[Test]
    public function fetching_future_conferences()
    {
        $pastConference = Conference::factory()
            ->dates(now()->subDays(2), now()->subDays(1))
            ->create();
        $futureConference = Conference::factory()
            ->dates(now()->addDay(), now()->addDay())
            ->create();

        $response = $this->call('GET', 'api/conferences?filter=future');

        $response->assertSuccessful();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.id', $futureConference->id);
    }

    #[Test]
    public function fetching_open_cfp_conferences()
    {
        $closedCfpConference = Conference::factory()
            ->cfpDates(now()->subDays(2), now()->subDays(1))
            ->create();
        $openCfpConference = Conference::factory()
            ->cfpDates(now()->subDay(), now()->addDay())
            ->create();

        $response = $this->call('GET', 'api/conferences?filter=open_cfp');

        $response->assertSuccessful();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.id', $openCfpConference->id);
    }

    #[Test]
    public function sorting_conferences_alphabetically(): void
    {
        $conferenceA = Conference::factory()->create(['title' => 'Your Conference']);
        $conferenceB = Conference::factory()->create(['title' => 'My Conference']);

        $response = $this->call('GET', 'api/conferences?sort=alpha');

        $response->assertSuccessful();
        $response->assertJsonCount(2, 'data');
        $response->assertJsonPath('data.0.id', $conferenceB->id);
        $response->assertJsonPath('data.1.id', $conferenceA->id);
    }

    #[Test]
    public function sorting_conferences_alphabetically_descending(): void
    {
        $conferenceA = Conference::factory()->create(['title' => 'Your Conference']);
        $conferenceB = Conference::factory()->create(['title' => 'My Conference']);

        $response = $this->call('GET', 'api/conferences?sort=-alpha');

        $response->assertSuccessful();
        $response->assertJsonCount(2, 'data');
        $response->assertJsonPath('data.0.id', $conferenceA->id);
        $response->assertJsonPath('data.1.id', $conferenceB->id);
    }

    #[Test]
    public function sorting_conferences_by_date(): void
    {
        $conferenceA = Conference::factory()->dates(now()->addDay())->create();
        $conferenceB = Conference::factory()->dates(now()->subDay())->create();

        $response = $this->call('GET', 'api/conferences?sort=date');

        $response->assertSuccessful();
        $response->assertJsonCount(2, 'data');
        $response->assertJsonPath('data.0.id', $conferenceB->id);
        $response->assertJsonPath('data.1.id', $conferenceA->id);
    }

    #[Test]
    public function sorting_conferences_by_date_descending(): void
    {
        $conferenceA = Conference::factory()->dates(now()->addDay())->create();
        $conferenceB = Conference::factory()->dates(now()->subDay())->create();

        $response = $this->call('GET', 'api/conferences?sort=-date');

        $response->assertSuccessful();
        $response->assertJsonCount(2, 'data');
        $response->assertJsonPath('data.0.id', $conferenceA->id);
        $response->assertJsonPath('data.1.id', $conferenceB->id);
    }

    #[Test]
    public function conferences_are_sorted_by_cfp_closing_next_by_default(): void
    {
        $conferenceA = Conference::factory()->create([
            'cfp_starts_at' => now()->subDay(),
            'cfp_ends_at' => null,
        ]);
        $conferenceB = Conference::factory()
            ->cfpDates(now()->subDays(2), now()->subDays(1))
            ->create();
        $conferenceC = Conference::factory()
            ->cfpDates(now()->addDay(), now()->addDay())
            ->create();

        $response = $this->call('GET', 'api/conferences?filter=all');

        $response->assertSuccessful();
        $response->assertJsonCount(3, 'data');
        $response->assertJsonPath('data.0.id', $conferenceC->id);
        $response->assertJsonPath('data.1.id', $conferenceA->id);
        $response->assertJsonPath('data.2.id', $conferenceB->id);
    }

    #[Test]
    public function can_fetch_one_conference(): void
    {
        $conference = Conference::factory()->create(['title' => 'My Conference']);

        $response = $this->call('GET', "api/conferences/{$conference->id}");

        $response->assertSuccessful();
        $response->assertJsonPath('data.id', $conference->id);
        $response->assertJsonPath('data.attributes.title', 'My Conference');
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
