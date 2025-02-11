<?php

namespace App\Registration\Write\Domain\ValueObjects;

use App\Registration\Write\Domain\Specifications\DangerousBreed\DangerousBreed;

abstract class PetBreed
{
    abstract public function getValue(): string;

    public function isDangerous(): bool
    {
        return new DangerousBreed()->isSatisfiedBy($this);
    }
}