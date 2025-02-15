<?php

namespace App\Registration\Write\Infrastructure\Eloquent;

use App\Registration\Write\Domain\Pet;
use App\Shared\Eloquent\Pet as PetEloquent;
use App\Shared\Exceptions\BadOperationException;
use App\Shared\Eloquent\PetType as PetTypeEloquent;
use App\Shared\Exceptions\ResourceNotFoundException;
use App\Shared\Eloquent\PetBreed as PetBreedEloquent;
use App\Registration\Write\Domain\ValueObjects\PetBreed;
use App\Registration\Write\Domain\ValueObjects\PetTypes;
use App\Registration\Write\Domain\PetRepositoryInterface;

class PetRepository implements PetRepositoryInterface
{

    private function getPetTypeEloquent(PetTypes $petType): PetTypeEloquent
    {
        $petTypeEloquent = PetTypeEloquent::query()->where("key", $petType->value)->first();

        if (isset($petTypeEloquent) === false) {
            throw new ResourceNotFoundException("api.exceptions.pet_type_not_found");
        }

        return $petTypeEloquent;
    }

    private function getPetBreedEloquent(PetBreed $petBreed): PetBreedEloquent
    {
        $petBreedEloquent = PetBreedEloquent::query()->where("key", (string) $petBreed)->first();

        if (isset($petBreedEloquent) === false) {
            throw new ResourceNotFoundException("api.exceptions.pet_breed_not_found");
        }

        return $petBreedEloquent;
    }

    public function persist(Pet $pet): int
    {
        $petTypeEloquent = $this->getPetTypeEloquent($pet->getPetType());
        $petBreedEloquent = null;

        if (is_null($pet->getPetBreed()) === false) {
            $petBreedEloquent = $this->getPetBreedEloquent($pet->getPetBreed());

            if ($petBreedEloquent->pet_type_id !== $petTypeEloquent->id) {
                throw new BadOperationException("api.exceptions.pet_breed_does_not_belong_to_pet_type");
            }
        }

        $petEloquent = new PetEloquent([
            "pet_type_id" => $petTypeEloquent->id,
            "pet_breed_id" => $petBreedEloquent?->id,
            "breed_mix" => $pet->getPetBreedMix(),
            "name" => $pet->getPetName(),
            "gender" => $pet->getPetGender()->value,
            "date_of_birth" => (string) $pet->getPetDateOfBirth(),
            "is_dangerous" => $pet->isDangerous()
        ]);

        $petEloquent->save();

        return $petEloquent->id;
    }
}