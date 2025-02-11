<?php

namespace App\Registration\Write\Domain\ValueObjects;

use Carbon\Carbon;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;

class PetDateOfBirthTest extends TestCase
{
    #[Test]
    #[Group("unit")]
    public function itSetsDateOfBirthWhenGivenDateOfBirth(): void
    {
        $dateOfBirth = PetDateOfBirth::fromDateOfBirth("2020-02-16");

        $this->assertEquals("2020-02-16", (string) $dateOfBirth);
    }

    #[Test]
    #[Group("unit")]
    public function itEstimatesDateOfBirthWhenGivenEstimatedAge(): void
    {
        Carbon::setTestNow(Carbon::parse("2025-02-16"));
        $dateOfBirth = PetDateOfBirth::fromEstimatedAge(5);

        $this->assertEquals("2020-02-16", (string) $dateOfBirth);
    }
}