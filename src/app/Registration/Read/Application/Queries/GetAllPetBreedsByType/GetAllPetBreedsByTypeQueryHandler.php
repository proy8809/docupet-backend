<?php

namespace App\Registration\Read\Application\Queries\GetAllPetBreedsByType;

use App\Shared\Eloquent\PetType as PetTypeEloquent;
use App\Shared\Exceptions\ResourceNotFoundException;

class GetAllPetBreedsByTypeQueryHandler
{
    /**
     * @return array<string>
     */
    public function handle(string $key): array
    {
        $petTypeEloquent = PetTypeEloquent::query()->with("petBreeds")->where("key", $key)->first();

        if (isset($petTypeEloquent) === false) {
            throw new ResourceNotFoundException("api.exceptions.pet_type_not_found");
        }

        /**
         * @var array<string>
         */
        $petTypeBreeds = $petTypeEloquent->petBreeds->pluck("key")->values()->toArray();

        return $petTypeBreeds;
    }
}