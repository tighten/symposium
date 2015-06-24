<?php

use LucaDegasperi\OAuth2Server\Authorizer;
use LucaDegasperi\OAuth2Server\Filters\OAuthFilter;

class oAuthTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    protected function assertIsJson($data)
    {
        $this->assertEquals(0, json_last_error(), 'Return is not JSON');
    }

    public function testCannotTestMeIfUnAuthenticated()
    {
        $response = $this->call('GET', 'api/me');
        $data = json_decode($response->getContent());

        $this->assertIsJson($data);
        $this->assertEquals('invalid_request', $data->error);
    }
}
