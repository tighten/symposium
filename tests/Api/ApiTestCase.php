<?php

use App\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
