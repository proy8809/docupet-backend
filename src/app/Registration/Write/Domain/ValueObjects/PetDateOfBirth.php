<?php

namespace App\Registration\Write\Domain\ValueObjects;

use Stringable;
use Carbon\Carbon;

class PetDateOfBirth implements Stringable
{
    public static function fromDateOfBirth(string $dateOfBirth): self
    {
        return new self(value: Carbon::parse($dateOfBirth));
    }

    public static function fromEstimatedAge(int $estimatedAge): self
    {
        return new self(value: Carbon::now()->subYears($estimatedAge));
    }

    public function __construct(
        private readonly Carbon $value
    ) {
    }

    public function __toString(): string
    {
        return $this->value->format("Y-m-d");
    }
}