<?php

namespace App\Registration\Write\Application\Commands\CreatePet;

use App\Registration\Write\Domain\PetFactory;
use App\Registration\Write\Domain\PetRepositoryInterface;

class CreatePetCommandHandler
{
    public function __construct(
        private readonly PetFactory $petFactory,
        private readonly PetRepositoryInterface $petRepository
    ) {
    }

    public function execute(CreatePetCommand $command): int
    {
        $pet = $this->petFactory->fromPrimitives(
            petNameValue: $command->petName,
            petGenderValue: $command->petGender,
            petDateOfBirthValue: $command->petDateOfBirth,
            petEstimatedAgeValue: $command->petEstimatedAge,
            petTypeValue: $command->petType,
            petBreedValue: $command->petBreed,
            petBreedMixValue: $command->petBreedMix,
        );

        return $this->petRepository->persist($pet);
    }
}