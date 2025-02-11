<?php

namespace App\Registration\Domain;

use App\Registration\Domain\Specifications\DangerousBreed;

abstract class PetBreed
{
    abstract public function getValue(): string;

    public function isDangerous(): bool
    {
        return new DangerousBreed()->isSatisfiedBy($this);
    }
}