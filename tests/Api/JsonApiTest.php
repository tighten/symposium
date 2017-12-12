<?php

use App\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class JsonApiTest extends TestCase
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
    public function uses_correct_json_api_header()
    {
        $response = $this->call('GET', '/api/user/1/talks');
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/vnd.api+json', $response->headers->get('Content-Type'));
    }
}
