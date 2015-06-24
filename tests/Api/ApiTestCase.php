<?php

use LucaDegasperi\OAuth2Server\Authorizer;
use LucaDegasperi\OAuth2Server\Filters\OAuthFilter;

class ApiTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
        Artisan::call('db:seed');

        $userId = 1;

        $this->authenticateAs($userId);
    }

    protected function parseJson($response)
    {
        return json_decode($response->getContent());
    }

    protected function assertIsJson($data)
    {
        $this->assertEquals(0, json_last_error(), 'Return is not JSON');
    }

    protected function authenticateAs($userId)
    {
        $this->app->singleton(Authorizer::class, function () use ($userId) {
            $authorizer = new DummyAuthorizer;
            $authorizer->userId = $userId;
            return $authorizer;
        });

        $this->app->singleton(OAuthFilter::class, function () use ($userId) {
            return new DummyOAuthFilter;
        });
    }
}

class DummyAuthorizer extends Authorizer
{
    public $userId;

    public function __construct()
    {
    }

    public function getResourceOwnerId()
    {
        return $this->userId;
    }

    public function getResourceOwnerType()
    {
        return 'user';
    }

    public function getSession()
    {
    }
}

class DummyOAuthFilter extends OAuthFilter
{
    public function __construct()
    {
    }

    public function filter()
    {
    }
}
