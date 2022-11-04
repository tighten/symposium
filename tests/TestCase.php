<?php

namespace Tests;

use App\Models\TightenSlack;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Testing\Fakes\NotificationFake;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    public $baseUrl = 'http://symposium.test';

    protected function setUp(): void
    {
        parent::setUp();

        NotificationFake::macro('assertSentToTightenSlack', function ($notification) {
            $this->assertSentTo(new TightenSlack(), $notification);
        });
    }
}
