<?php

namespace Tests;

use App\Exceptions\Handler;
use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Throwable;

class IntegrationTestCase extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Session::start();
        Artisan::call('migrate');
    }

    protected function disableExceptionHandling()
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
