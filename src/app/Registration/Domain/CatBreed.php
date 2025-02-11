<?php

namespace App\Registration\Domain;

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