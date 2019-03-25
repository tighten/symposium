<?php

namespace Tests\Api;

use App\User;
use Artisan;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ApiTestCase extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
        Artisan::call('db:seed');

        $this->user = User::first();
        Passport::actingAs($this->user);
    }
}
