<?php

namespace App\Registration\Write\Domain\ValueObjects;

class PetBreed
{
    public function __construct(
        public readonly string $value,
    ) {
    }

    public function isEqualTo(PetBreed $petBreed): bool
    {
        return $this->value === $petBreed->value;
    }
}