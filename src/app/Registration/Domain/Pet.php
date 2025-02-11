<?php

namespace App\Registration\Domain;

use Carbon\Carbon;
use App\Shared\Exceptions\BadOperationException;
use App\Registration\Domain\Policies\EstimatedAgeDateOfBirth;

class Pet
{
    public function __construct(
        private readonly PetTypes $petType,
        private readonly ?PetBreed $petBreed,
        private readonly string $breedMix,
        private readonly string $name,
        private readonly PetGenders $gender,
        private readonly ?Carbon $dateOfBirth,
        private readonly ?int $estimatedAge
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

    public function getDateOfBirth(): Carbon
    {
        if (isset($this->dateOfBirth) === false && isset($this->estimatedAge) === false) {
            throw new BadOperationException("api.exceptions.invalid_birth_data");
        }

        if (isset($this->dateOfBirth) === true) {
            return $this->dateOfBirth;
        }

        return new EstimatedAgeDateOfBirth()->calculate($this->estimatedAge);
    }

    public function isDangerous(): bool
    {
        if (isset($this->petBreed) === false) {
            return false;
        }

        return $this->petBreed->isDangerous();
    }
}