<?php

namespace App\Registration\Write\Domain;

use App\Shared\Exceptions\BadOperationException;
use App\Registration\Write\Domain\ValueObjects\CatBreed;
use App\Registration\Write\Domain\ValueObjects\DogBreed;
use App\Registration\Write\Domain\ValueObjects\PetBreed;
use App\Registration\Write\Domain\ValueObjects\PetTypes;
use App\Registration\Write\Domain\ValueObjects\PetGenders;
use App\Registration\Write\Domain\ValueObjects\PetDateOfBirth;

class PetFactory
{
    private function getPetType(string $value): PetTypes
    {
        $petType = PetTypes::tryFrom($value);

        if (isset($petType) === false) {
            throw new BadOperationException("api.exceptions.invalid_pet_type");
        }

        return $petType;
    }

    private function getPetBreed(PetTypes $petType, string $value): PetBreed
    {
        return match ($petType) {
            PetTypes::Cat => new CatBreed($value),
            PetTypes::Dog => new DogBreed($value)
        };
    }

    private function getPetGender(string $value): PetGenders
    {
        $petGender = PetGenders::tryFrom($value);

        if (isset($petGender) === false) {
            throw new BadOperationException("api.exceptions.invalid_pet_gender");
        }

        return $petGender;
    }

    private function getPetDateOfBirth(?string $dateOfBirth, ?int $estimatedAge): PetDateOfBirth
    {
        if (isset($dateOfBirth) === true) {
            return PetDateOfBirth::fromDateOfBirth($dateOfBirth);
        }

        if (isset($estimatedAge) === false) {
            throw new BadOperationException("api.exceptions.missing_birthdate_data");
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
        $petType = $this->getPetType($petTypeValue);
        $petBreed = $this->getPetBreed($petType, $petBreedValue);
        $petGender = $this->getPetGender($genderValue);
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