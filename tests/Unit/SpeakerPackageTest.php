<?php

namespace Tests\Unit;

use App\Casts\SpeakerPackage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SpeakerPackageTest extends TestCase
{
    #[Test]
    public function formatting_as_decimal(): void
    {
        $speakerPackage = new SpeakerPackage([
            'currency' => 'usd',
            'food' => 1000,
            'travel' => 0,
        ]);

        $this->assertEquals('10.00', $speakerPackage->toDecimal('food'));
        $this->assertEquals(null, $speakerPackage->toDecimal('travel'));
    }
}
