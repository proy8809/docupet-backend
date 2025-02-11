<?php

namespace App\Registration\Write\Domain;

use Carbon\Carbon;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use function PHPUnit\Framework\assertEquals;

class DateOfBirthTest extends TestCase
{
    #[Test]
    #[Group("unit")]
    public function fromDateOfBirthReturnsCreatesDateOfBirthWithDate(): void
    {
        $dateOfBirth = DateOfBirth::fromDateOfBirth("2020-02-16");

        $this->assertEquals("2020-02-16", $dateOfBirth->getValue());
    }

    #[Test]
    #[Group("unit")]
    public function fromEstimatedAgeCalculatedDateOfBirth(): void
    {
        Carbon::setTestNow(Carbon::parse("2025-02-16"));
        $dateOfBirth = DateOfBirth::fromEstimatedAge(5);

        $this->assertEquals("2020-02-16", $dateOfBirth->getValue());
    }
}