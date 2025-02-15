<?php

namespace App\Registration\Write\Domain\ValueObjects;

use Stringable;

class PetBreed implements Stringable
{
    public function __construct(
        private readonly string $value,
    ) {
    }

    public function isEqualTo(PetBreed $petBreed): bool
    {
        return $this->value === $petBreed->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}