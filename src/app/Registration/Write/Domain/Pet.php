<?php

namespace App\Registration\Write\Domain;

class Pet
{
    public function __construct(
        private readonly PetTypes $petType,
        private readonly ?PetBreed $petBreed,
        private readonly string $breedMix,
        private readonly string $name,
        private readonly PetGenders $gender,
        private readonly PetDateOfBirth $dateOfBirth,
    ) {
    }

    public function getPetType(): PetTypes
    {
        return $this->petType;
    }

    public function getPetBreed(): ?PetBreed
    {
        return $this->petBreed;
    }

    public function getBreedMix(): string
    {
        return $this->breedMix;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGender(): PetGenders
    {
        return $this->gender;
    }

    public function getDateOfBirth(): PetDateOfBirth
    {
        return $this->dateOfBirth;
    }

    public function isDangerous(): bool
    {
        if (isset($this->petBreed) === false) {
            return false;
        }

        return $this->petBreed->isDangerous();
    }
}