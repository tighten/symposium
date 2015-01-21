<?php

class IntegrationTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
    }
}
