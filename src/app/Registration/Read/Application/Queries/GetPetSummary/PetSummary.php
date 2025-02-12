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
            "name" => $this->petName,
            "age" => $this->petAge,
            "gender" => $this->petGender,
            "type" => $this->petType,
            "breed" => $this->petBreed,
            "breed_mix" => $this->petBreedMix,
            "is_dangerous" => $this->isDangerous
        ];
    }
}