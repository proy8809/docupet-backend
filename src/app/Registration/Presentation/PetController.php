<?php

namespace App\Registration\Presentation;

use Illuminate\Http\JsonResponse;
use App\Shared\Controllers\Controller;
use App\Registration\Presentation\Requests\CreatePetRequest;
use App\Registration\Write\Application\Commands\CreatePet\CreatePetCommandHandler;
use App\Registration\Read\Application\Queries\GetPetSummary\GetPetSummaryQueryHandler;

class PetController extends Controller
{
    public function __construct(
        private readonly CreatePetCommandHandler $createPet,
        private readonly GetPetSummaryQueryHandler $getPetSummary,
    ) {
    }

    public function store(CreatePetRequest $createPetRequest): JsonResponse
    {
        $petId = $this->createPet->execute($createPetRequest->toCommand());

        $body = $this->getPetSummary->handle($petId);

        return $this->saved($body);
    }
}