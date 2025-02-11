<?php

namespace App\Registration\Domain;

class PetType
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