<?php

namespace App\Registration\Read\Application\Queries\GetPetSummary;

use Carbon\Carbon;
use App\Shared\Eloquent\Pet as PetEloquent;
use App\Shared\Exceptions\ResourceNotFoundException;

class GetPetSummaryQueryHandler
{
    public function handle(int $id): PetSummary
    {
        $petEloquent = PetEloquent::query()->with(["petType", "petBreed"])->find($id);

        if (isset($petEloquent) === false) {
            throw new ResourceNotFoundException("api.exceptions.pet_not_found");
        }

        return new PetSummary(
            petName: $petEloquent->name,
            petAge: Carbon::parse($petEloquent->date_of_birth)->age,
            petGender: $petEloquent->gender,
            petType: $petEloquent->petType->key,
            petBreed: $petEloquent->petBreed?->key,
            petBreedMix: $petEloquent->breed_mix,
            isDangerous: $petEloquent->is_dangerous
        );
    }
}