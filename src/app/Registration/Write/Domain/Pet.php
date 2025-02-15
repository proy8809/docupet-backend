<?php

namespace App\Registration\Write\Domain;

use App\Registration\Write\Domain\ValueObjects\PetBreed;
use App\Registration\Write\Domain\ValueObjects\PetTypes;
use App\Registration\Write\Domain\ValueObjects\PetGenders;
use App\Registration\Write\Domain\ValueObjects\PetDateOfBirth;

class Pet
{
    public function __construct(
        private readonly string $petName,
        private readonly PetGenders $petGender,
        private readonly PetDateOfBirth $petDateOfBirth,
        private readonly PetTypes $petType,
        private readonly ?PetBreed $petBreed,
        private readonly string $petBreedMix,
        private bool $isDangerous = false
    ) {
    }

    public function getPetName(): string
    {
        return $this->petName;
    }

    public function getPetGender(): PetGenders
    {
        return $this->petGender;
    }

    public function getPetDateOfBirth(): PetDateOfBirth
    {
        return $this->petDateOfBirth;
    }

    public function getPetType(): PetTypes
    {
        return $this->petType;
    }

    public function getPetBreed(): ?PetBreed
    {
        return $this->petBreed;
    }

    public function getPetBreedMix(): string
    {
        return $this->petBreedMix;
    }

    public function flagAsDangerous(): void
    {
        $this->isDangerous = true;
    }

    public function isDangerous(): bool
    {
        return $this->isDangerous;
    }
}