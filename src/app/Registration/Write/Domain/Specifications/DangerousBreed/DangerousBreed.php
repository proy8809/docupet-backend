<?php

namespace App\Registration\Write\Domain\Specifications\DangerousBreed;

use App\Registration\Write\Domain\ValueObjects\CatBreed;
use App\Registration\Write\Domain\ValueObjects\PetBreed;

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