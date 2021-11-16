<?php

namespace Tests;

use App\Exceptions\ValidationException;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, LazilyRefreshDatabase;

    public $baseUrl = 'http://symposium.test';

    function assertHasError($key, ValidationException $exception)
    {
        $this->assertContains($key, $exception->errors()->keys());
    }

    function validationErrorNotThrown($key)
    {
        $this->fail("A validation error for {$key} was expected but not thrown");
    }
}
