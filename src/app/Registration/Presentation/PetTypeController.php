<?php

namespace App\Registration\Presentation;

use Illuminate\Http\JsonResponse;
use App\Shared\Controllers\Controller;
use App\Registration\Read\Application\Queries\GetAllPetTypes\GetAllPetTypesQueryHandler;
use App\Registration\Read\Application\Queries\GetAllPetBreedsByType\GetAllPetBreedsByTypeQueryHandler;

class PetTypeController extends Controller
{
    public function __construct(
        private readonly GetAllPetTypesQueryHandler $getAllPetTypes,
        private readonly GetAllPetBreedsByTypeQueryHandler $getAllPetBreedsByType,
    ) {
    }

    public function getAll(): JsonResponse
    {
        $body = $this->getAllPetTypes->handle();

        return $this->ok($body);
    }

    public function getBreeds(string $typeKey): JsonResponse
    {
        $body = $this->getAllPetBreedsByType->handle($typeKey);

        return $this->ok($body);
    }
}