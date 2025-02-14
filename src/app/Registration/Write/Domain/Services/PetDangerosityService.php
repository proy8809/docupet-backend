<?php

namespace App\Registration\Write\Domain\Services;

use App\Registration\Write\Domain\Pet;
use App\Registration\Write\Domain\Specifications\PetDangerosity\IsADog;
use App\Registration\Write\Domain\Services\PetDangerosityServiceInterface;
use App\Registration\Write\Domain\Specifications\PetDangerosity\IsADangerousBreed;

class PetDangerosityService implements PetDangerosityServiceInterface
{
    public function isDangerous(Pet $pet): bool
    {
        $isADangerousBreed = new IsADangerousBreed();
        $isADog = new IsADog();

        return $isADog->and($isADangerousBreed)->isSatisfiedBy($pet);
    }

}