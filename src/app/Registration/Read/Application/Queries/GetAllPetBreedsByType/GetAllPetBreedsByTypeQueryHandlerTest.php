<?php

namespace App\Registration\Read\Application\Queries\GetAllPetBreedsByType;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Shared\Eloquent\PetType as PetTypeEloquent;
use App\Shared\Exceptions\ResourceNotFoundException;
use App\Shared\Eloquent\PetBreed as PetBreedEloquent;

class GetAllPetBreedsByTypeQueryHandlerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group("integration")]
    public function itReturnsAllPetTypeKeys(): void
    {
        $catTypeEloquent = PetTypeEloquent::create(["key" => "cat"]);
        $dogTypeEloquent = PetTypeEloquent::create(["key" => "dog"]);

        PetBreedEloquent::create(["pet_type_id" => $catTypeEloquent->id, "key" => "russian_blue"]);
        PetBreedEloquent::create(["pet_type_id" => $dogTypeEloquent->id, "key" => "samoyed"]);
        PetBreedEloquent::create(["pet_type_id" => $dogTypeEloquent->id, "key" => "german_shepherd"]);

        $handler = new GetAllPetBreedsByTypeQueryHandler();
        $dogBreeds = $handler->handle("dog");

        $this->assertEquals(["samoyed", "german_shepherd"], $dogBreeds);
    }

    #[Test]
    #[Group("integration")]
    public function itThrowsExceptionWhenPetTypeNotFound(): void
    {
        $handler = new GetAllPetBreedsByTypeQueryHandler();
        $action = fn() => $handler->handle("dog");

        $this->assertThrows($action, ResourceNotFoundException::class);
    }
}