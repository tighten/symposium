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

    protected function parseJson($response)
    {
        return json_decode($response->getContent());
    }

    protected function assertIsJson($data)
    {
        $this->assertEquals(0, json_last_error(), 'Return is not JSON');
    }
}
