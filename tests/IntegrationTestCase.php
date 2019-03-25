<?php

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

class IntegrationTestCase extends TestCase
{
    public function setUp()
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
            
            public function report(Exception $e)
            {
                // no-op
            }
            
            public function render($request, Exception $e)
            {
                throw $e;
            }
        });
    }
}
