<?php

namespace App\Registration\Write\Domain\Services;

use App\Registration\Write\Domain\Pet;

interface PetDangerosityServiceInterface
{
    public function isDangerous(Pet $pet): bool;
}