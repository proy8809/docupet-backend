<?php

namespace App\Registration\Write\Domain\ValueObjects;

class CatBreed extends PetBreed
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