<?php

namespace App\Registration\Write\Domain\Specifications\PetDangerosity;

use App\Registration\Write\Domain\Pet;
use App\Registration\Write\Domain\ValueObjects\PetTypes;
use App\Registration\Write\Domain\Specifications\Specification;

class IsADog extends Specification
{
    public function isSatisfiedBy(Pet $pet): bool
    {
        return $pet->getPetType() === PetTypes::Dog;
    }
}