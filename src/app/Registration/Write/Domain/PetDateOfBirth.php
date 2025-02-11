<?php

namespace App\Registration\Write\Domain;

use Carbon\Carbon;

class PetDateOfBirth
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

    public function getValue(): string
    {
        return $this->value->format("Y-m-d");
    }
}