<?php

namespace App\Registration\Write\Infrastructure;

use Mockery;
use Carbon\Carbon;
use Tests\TestCase;
use App\Registration\Write\Domain\Pet;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use App\Shared\Exceptions\BadOperationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Shared\Eloquent\PetType as PetTypeEloquent;
use App\Shared\Exceptions\ResourceNotFoundException;
use App\Shared\Eloquent\PetBreed as PetBreedEloquent;
use App\Registration\Write\Domain\ValueObjects\CatBreed;
use App\Registration\Write\Domain\ValueObjects\DogBreed;
use App\Registration\Write\Domain\ValueObjects\PetBreed;
use App\Registration\Write\Domain\ValueObjects\PetTypes;
use App\Registration\Write\Domain\ValueObjects\PetGenders;
use App\Registration\Write\Domain\ValueObjects\PetDateOfBirth;
use App\Registration\Write\Infrastructure\Eloquent\PetRepository;

class PetRepositoryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group("integration")]
    public function persistThrowsExceptionWhenTypeDoesNotExist(): void
    {
        $pet = new Pet(
            petType: PetTypes::Dog,
            petBreed: new DogBreed("samoyed"),
            breedMix: "",
            name: "Kiwi",
            gender: PetGenders::Female,
            dateOfBirth: Mockery::mock(PetDateOfBirth::class),
        );

        // ACT
        $repository = app(PetRepository::class);
        $action = fn() => $repository->persist($pet);

        // ASSERT
        $this->assertThrows($action, ResourceNotFoundException::class);
    }

    #[Test]
    #[Group("integration")]
    public function persistThrowsExceptionWhenBreedDoesNotExist(): void
    {
        // ARRANGE
        PetTypeEloquent::create(["key" => "dog"]);

        $pet = new Pet(
            petType: PetTypes::Dog,
            petBreed: new DogBreed("samoyed"),
            breedMix: "",
            name: "Kiwi",
            gender: PetGenders::Female,
            dateOfBirth: Mockery::mock(PetDateOfBirth::class),
        );

        // ACT
        $repository = app(PetRepository::class);
        $action = fn() => $repository->persist($pet);

        // ASSERT
        $this->assertThrows($action, ResourceNotFoundException::class);
    }

    #[Test]
    #[Group("integration")]
    public function persistThrowsExceptionWhenBreedDoesNotBelongToType(): void
    {
        // ARRANGE
        $petTypesEloquent = [
            PetTypeEloquent::create(["key" => "cat"]),
            PetTypeEloquent::create(["key" => "dog"])
        ];

        PetBreedEloquent::create(["pet_type_id" => $petTypesEloquent[0]->id, "key" => "russian_blue"]);
        PetBreedEloquent::create(["pet_type_id" => $petTypesEloquent[1]->id, "key" => "samoyed"]);

        $pet = new Pet(
            petType: PetTypes::Dog,
            petBreed: new CatBreed("russian_blue"),
            breedMix: "",
            name: "Cc",
            gender: PetGenders::Female,
            dateOfBirth: Mockery::mock(PetDateOfBirth::class),
        );

        // ACT
        $repository = app(PetRepository::class);
        $action = fn() => $repository->persist($pet);

        // ASSERT
        $this->assertThrows($action, BadOperationException::class);
    }

    #[Test]
    #[Group("integration")]
    public function persistPersistsDataInDatabase(): void
    {
        // ARRANGE
        $petTypeEloquent = PetTypeEloquent::create(["key" => "dog"]);
        $petBreedEloquent = PetBreedEloquent::create(["pet_type_id" => $petTypeEloquent->id, "key" => "samoyed"]);

        $pet = new Pet(
            petType: PetTypes::Dog,
            petBreed: new DogBreed("samoyed"),
            breedMix: "",
            name: "Kiwi",
            gender: PetGenders::Female,
            dateOfBirth: PetDateOfBirth::fromDateOfBirth("2020-02-16"),
        );

        // ACT
        $repository = app(PetRepository::class);
        $petId = $repository->persist($pet);

        // ASSERT
        $this->assertDatabaseHas("pets", [
            "id" => $petId,
            "pet_type_id" => $petTypeEloquent->id,
            "pet_breed_id" => $petBreedEloquent->id,
            "breed_mix" => "",
            "name" => "Kiwi",
            "gender" => PetGenders::Female->value,
            "date_of_birth" => "2020-02-16"
        ]);
    }
}