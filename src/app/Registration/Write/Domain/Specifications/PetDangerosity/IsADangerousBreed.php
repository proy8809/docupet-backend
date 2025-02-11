<?php

namespace App\Registration\Write\Domain\Specifications\PetDangerosity;

use App\Registration\Write\Domain\Pet;
use App\Registration\Write\Domain\ValueObjects\PetBreed;
use App\Registration\Write\Domain\Specifications\Specification;

class IsADangerousBreed extends Specification
{
    public function isSatisfiedBy(Pet $pet): bool
    {
        if (is_null($pet->getPetBreed()) === true) {
            return false;
        }

        return array_any(
            DangerousBreeds::toBreeds(),
            fn(PetBreed $petBreed) => $petBreed->isEqualTo($pet->getPetBreed())
        );
    }
}