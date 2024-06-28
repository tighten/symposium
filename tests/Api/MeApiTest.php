<?php

namespace Tests\Api;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class MeApiTest extends TestCase
{
    /** @test */
    public function can_fetch_my_info()
    {
        Passport::actingAs(User::factory()->create());

        $response = $this->call('GET', 'api/me');
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertIsObject($data->data);
    }

    /** @test */
    public function only_authenticated_users_can_fetch_user_data(): void
    {
        $response = $this->getJson('api/me');

        $response->assertUnauthorized();
    }
}
