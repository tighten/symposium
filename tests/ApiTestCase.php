<?php

class ApiTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
        Artisan::call('db:seed');

        Auth::loginUsingId(1);
        // OR:
        // $this->be(User::find(1));
    }
}
