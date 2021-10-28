<?php

namespace Tests;

use App\Exceptions\Handler;
use App\Exceptions\ValidationException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Throwable;

class IntegrationTestCase extends TestCase
{
    /** @before */
    public function prepareSessionAndDatabase()
    {
        parent::setUp();
        Session::start();
        Artisan::call('migrate');
    }

    public function assertHasError($key, ValidationException $exception)
    {
        $this->assertContains($key, $exception->errors()->keys());
    }

    public function validationErrorNotThrown($key)
    {
        $this->fail("A validation error for {$key} was expected but not thrown");
    }

    public function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct()
            {
            }

            public function report(Throwable $exception)
            {
                // no-op
            }

            public function render($request, Throwable $exception)
            {
                throw $exception;
            }
        });
    }
}
