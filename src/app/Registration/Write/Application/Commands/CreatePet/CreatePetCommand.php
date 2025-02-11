<?php

namespace App\Registration\Write\Application\Commands\CreatePet;

class CreatePetCommand
{
    public function __construct(
        public readonly string $petType,
        public readonly string $petBreed,
        public readonly string $breedMix,
        public readonly string $name,
        public readonly string $gender,
        public readonly ?string $dateOfBirth,
        public readonly ?int $estimatedAge
    ) {
    }
}