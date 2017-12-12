<?php

use App\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MeApiTest extends TestCase
{
    use DatabaseTransactions;

    public function setup()
    {
        parent::setUp();

        Artisan::call('migrate');
        Artisan::call('db:seed');

        $user = User::first();
        Passport::actingAs($user);
    }

    /** @test */
    public function can_fetch_my_info()
    {
        $response = $this->call('GET', 'api/me');
        $data = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInternalType('object', $data->data);
    }
}
