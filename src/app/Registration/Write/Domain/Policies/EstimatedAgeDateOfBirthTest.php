<?php

namespace App\Registration\Write\Domain\Policies;

use Carbon\Carbon;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;

class EstimatedAgeDateOfBirthTest extends TestCase
{
    #[Test]
    #[Group("unit")]
    public function calculateSubtractsYearsFromToday(): void
    {
        Carbon::setTestNow(Carbon::parse("2025-02-11"));

        $actual = new EstimatedAgeDateOfBirth()->calculate(10);

        $this->assertEquals("2015-02-11", $actual->format("Y-m-d"));
    }
}