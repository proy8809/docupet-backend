<?php

namespace App\Registration\Write\Application\Commands\CreatePet;

class CreatePetCommand
{
    public function __construct(
        public readonly string $petName,
        public readonly string $petGender,
        public readonly ?string $petDateOfBirth,
        public readonly ?int $petEstimatedAge,
        public readonly string $petType,
        public readonly ?string $petBreed,
        public readonly string $petBreedMix,
    ) {
    }
}