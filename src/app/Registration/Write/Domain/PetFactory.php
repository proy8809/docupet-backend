<?php

namespace App\Registration\Write\Domain;

use App\Shared\Exceptions\BadOperationException;
use App\Registration\Write\Domain\ValueObjects\PetBreed;
use App\Registration\Write\Domain\ValueObjects\PetTypes;
use App\Registration\Write\Domain\ValueObjects\PetGenders;
use App\Registration\Write\Domain\ValueObjects\PetDateOfBirth;
use App\Registration\Write\Domain\Services\PetDangerosityServiceInterface;

class PetFactory
{
    public function __construct(
        private readonly PetDangerosityServiceInterface $petDangerosityService
    ) {
    }

    private function makePetType(string $value): PetTypes
    {
        $petType = PetTypes::tryFrom($value);

        if (isset($petType) === false) {
            throw new BadOperationException("api.exceptions.invalid_pet_type");
        }

        return $petType;
    }

    private function makePetGender(string $value): PetGenders
    {
        $petGender = PetGenders::tryFrom($value);

        if (isset($petGender) === false) {
            throw new BadOperationException("api.exceptions.invalid_pet_gender");
        }

        return $petGender;
    }

    private function makePetDateOfBirth(?string $dateOfBirth, ?int $estimatedAge): PetDateOfBirth
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
        string $petNameValue,
        string $petGenderValue,
        ?string $petDateOfBirthValue,
        ?int $petEstimatedAgeValue,
        string $petTypeValue,
        ?string $petBreedValue,
        string $petBreedMixValue,
    ): Pet {
        $petType = $this->makePetType($petTypeValue);

        $pet = new Pet(
            petName: $petNameValue,
            petGender: $this->makePetGender($petGenderValue),
            petDateOfBirth: $this->makePetDateOfBirth($petDateOfBirthValue, $petEstimatedAgeValue),
            petType: $petType,
            petBreed: isset($petBreedValue) === true ? new PetBreed($petBreedValue) : null,
            petBreedMix: $petBreedMixValue
        );

        if ($this->petDangerosityService->isDangerous($pet) === true) {
            $pet->flagAsDangerous();
        }

        return $pet;
    }
}