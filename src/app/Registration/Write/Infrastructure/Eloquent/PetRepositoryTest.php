<?php

namespace App\Registration\Write\Infrastructure\Eloquent;

use Mockery;
use Tests\TestCase;
use App\Registration\Write\Domain\Pet;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use App\Shared\Exceptions\BadOperationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Shared\Eloquent\PetType as PetTypeEloquent;
use App\Shared\Exceptions\ResourceNotFoundException;
use App\Shared\Eloquent\PetBreed as PetBreedEloquent;
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
    public function itThrowsAnExceptionWhenPersistedTypeDoesNotExist(): void
    {
        $pet = new Pet(
            petName: "Kiwi",
            petGender: PetGenders::Female,
            petDateOfBirth: Mockery::mock(PetDateOfBirth::class),
            petType: PetTypes::Dog,
            petBreed: new PetBreed("samoyed"),
            petBreedMix: "",
        );

        // ACT
        $repository = app(PetRepository::class);
        $action = fn() => $repository->persist($pet);

        // ASSERT
        $this->assertThrows($action, ResourceNotFoundException::class);
    }

    #[Test]
    #[Group("integration")]
    public function itThrowsAnExceptionWhenPersistedBreedDoesNotExist(): void
    {
        // ARRANGE
        PetTypeEloquent::create(["key" => PetTypes::Dog->value]);

        $pet = new Pet(
            petName: "Kiwi",
            petGender: PetGenders::Female,
            petDateOfBirth: Mockery::mock(PetDateOfBirth::class),
            petType: PetTypes::Dog,
            petBreed: new PetBreed("samoyed"),
            petBreedMix: "",
        );

        // ACT
        $repository = app(PetRepository::class);
        $action = fn() => $repository->persist($pet);

        // ASSERT
        $this->assertThrows($action, ResourceNotFoundException::class);
    }

    #[Test]
    #[Group("integration")]
    public function itThrowsAnExceptionWhenPersistedBreedDoesNotBelongToType(): void
    {
        // ARRANGE
        $petTypesEloquent = [
            PetTypeEloquent::create(["key" => PetTypes::Cat->value]),
            PetTypeEloquent::create(["key" => PetTypes::Dog->value])
        ];

        PetBreedEloquent::create(["pet_type_id" => $petTypesEloquent[0]->id, "key" => "russian_blue"]);
        PetBreedEloquent::create(["pet_type_id" => $petTypesEloquent[1]->id, "key" => "samoyed"]);

        $pet = new Pet(
            petName: "Kiwi",
            petGender: PetGenders::Female,
            petDateOfBirth: Mockery::mock(PetDateOfBirth::class),
            petType: PetTypes::Cat,
            petBreed: new PetBreed("samoyed"),
            petBreedMix: "",
        );

        // ACT
        $repository = app(PetRepository::class);
        $action = fn() => $repository->persist($pet);

        // ASSERT
        $this->assertThrows($action, BadOperationException::class);
    }

    #[Test]
    #[Group("integration")]
    public function itPersistsData(): void
    {
        // ARRANGE
        $petTypeEloquent = PetTypeEloquent::create(["key" => PetTypes::Dog->value]);
        $petBreedEloquent = PetBreedEloquent::create(["pet_type_id" => $petTypeEloquent->id, "key" => "samoyed"]);

        $pet = new Pet(
            petName: "Kiwi",
            petGender: PetGenders::Female,
            petDateOfBirth: PetDateOfBirth::fromDateOfBirth("2020-02-16"),
            petType: PetTypes::Dog,
            petBreed: new PetBreed("samoyed"),
            petBreedMix: "",
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