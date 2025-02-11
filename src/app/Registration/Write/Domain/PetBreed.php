<?php

namespace App\Registration\Write\Domain;

use App\Registration\Write\Domain\Specifications\DangerousBreed;

abstract class PetBreed
{
    abstract public function getValue(): string;

    public function isDangerous(): bool
    {
        return new DangerousBreed()->isSatisfiedBy($this);
    }
}