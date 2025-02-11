<?php

namespace App\Registration\Domain\Specifications;

use App\Registration\Domain\CatBreed;
use App\Registration\Domain\PetBreed;

class DangerousBreed
{
    public function isSatisfiedBy(PetBreed $petBreed): bool
    {
        if ($petBreed instanceof CatBreed) {
            return false;
        }

        $dangerousBreeds = array_column(DangerousDogBreeds::cases(), "value");

        return array_any(
            $dangerousBreeds,
            fn(string $dangerousBreed) => $petBreed->getValue() === $dangerousBreed
        );
    }
}