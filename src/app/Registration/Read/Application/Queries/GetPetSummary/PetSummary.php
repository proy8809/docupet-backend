<?php

namespace App\Registration\Read\Application\Queries\GetPetSummary;

use JsonSerializable;

class PetSummary implements JsonSerializable
{
    public function __construct(
        public readonly string $petName,
        public readonly int $petAge,
        public readonly string $petGender,
        public readonly string $petType,
        public readonly ?string $petBreed,
        public readonly string $petBreedMix,
        public readonly bool $isDangerous
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            "pet_name" => $this->petName,
            "pet_age" => $this->petAge,
            "pet_gender" => $this->petGender,
            "pet_type" => $this->petType,
            "pet_breed" => $this->petBreed,
            "pet_breed_mix" => $this->petBreedMix,
            "is_dangerous" => $this->isDangerous
        ];
    }
}