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
            petTypeValue: $command->petType,
            petBreedValue: $command->petBreed,
            breedMixValue: $command->breedMix,
            nameValue: $command->name,
            genderValue: $command->gender,
            dateOfBirthValue: $command->dateOfBirth,
            estimatedAgeValue: $command->estimatedAge
        );

        return $this->petRepository->persist($pet);
    }
}