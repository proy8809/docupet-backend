<?php

namespace App\Registration\Read\Application\Queries\GetAllPetTypes;

use App\Shared\Eloquent\PetType as PetTypeEloquent;

class GetAllPetTypesQueryHandler
{
    /**
     * @return array<string>
     */
    public function handle(): array
    {
        /**
         * @var array<string>
         */
        $petTypes = PetTypeEloquent::pluck("key")->toArray();

        return $petTypes;
    }
}