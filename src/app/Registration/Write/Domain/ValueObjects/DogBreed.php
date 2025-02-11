<?php

namespace App\Registration\Write\Domain\ValueObjects;

class DogBreed extends PetBreed
{
    public function __construct(
        private readonly string $value
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }
}