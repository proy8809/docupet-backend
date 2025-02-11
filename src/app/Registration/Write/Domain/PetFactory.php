<?php

namespace App\Registration\Write\Domain;

use App\Shared\Exceptions\BadOperationException;

class PetFactory
{
    private function getPetBreed(PetTypes $petType, string $value): PetBreed
    {
        return match ($petType) {
            PetTypes::Cat => new CatBreed($value),
            PetTypes::Dog => new DogBreed($value)
        };
    }

    private function getPetDateOfBirth(?string $dateOfBirth, ?int $estimatedAge): PetDateOfBirth
    {
        if (isset($dateOfBirth) === true) {
            return PetDateOfBirth::fromDateOfBirth($dateOfBirth);
        }

        if (isset($estimatedAge) === false) {
            throw new BadOperationException("api.exception.missing_birthdate_data");
        }

        return PetDateOfBirth::fromEstimatedAge($estimatedAge);
    }

    public function fromPrimitives(
        string $petTypeValue,
        string $petBreedValue,
        string $breedMixValue,
        string $nameValue,
        string $genderValue,
        ?string $dateOfBirthValue,
        ?int $estimatedAgeValue
    ): Pet {
        $petType = PetTypes::from($petTypeValue);
        $petBreed = $this->getPetBreed($petType, $petBreedValue);
        $petGender = PetGenders::from($genderValue);
        $dateOfBirth = $this->getPetDateOfBirth($dateOfBirthValue, $estimatedAgeValue);

        return new Pet(
            petType: $petType,
            petBreed: $petBreed,
            breedMix: $breedMixValue,
            name: $nameValue,
            gender: $petGender,
            dateOfBirth: $dateOfBirth
        );
    }
}