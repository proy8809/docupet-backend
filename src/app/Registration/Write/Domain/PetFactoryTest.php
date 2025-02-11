<?php

namespace App\Registration\Write\Domain;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use App\Shared\Exceptions\BadOperationException;

class PetFactoryTest extends TestCase
{
    #[Test]
    #[Group("unit")]
    public function fromPrimitivesThrowsExceptionWhenMissingBirthData(): void
    {
        $factory = new PetFactory();
        $action = fn() => $factory->fromPrimitives(
            petTypeValue: "dog",
            petBreedValue: "samoyed",
            breedMixValue: "",
            nameValue: "Kiwi",
            genderValue: "f",
            dateOfBirthValue: null,
            estimatedAgeValue: null
        );

        $this->assertThrows($action, BadOperationException::class);
    }

    #[Test]
    #[Group("unit")]
    public function fromPrimitivesInjectsCatBreedWhenTypeIsCat(): void
    {
        $factory = new PetFactory();

        $pet = $factory->fromPrimitives(
            petTypeValue: "cat",
            petBreedValue: "foldex",
            breedMixValue: "",
            nameValue: "Pacha",
            genderValue: "m",
            dateOfBirthValue: "2017-02-23",
            estimatedAgeValue: null
        );

        $this->assertInstanceOf(CatBreed::class, $pet->getPetBreed());
    }

    #[Test]
    #[Group("unit")]
    public function fromPrimitivesInjectsDogBreedWhenTypeIsDog(): void
    {
        $factory = new PetFactory();

        $pet = $factory->fromPrimitives(
            petTypeValue: "dog",
            petBreedValue: "samoyed",
            breedMixValue: "",
            nameValue: "Kiwi",
            genderValue: "f",
            dateOfBirthValue: "2020-02-16",
            estimatedAgeValue: null
        );

        $this->assertInstanceOf(DogBreed::class, $pet->getPetBreed());
    }
}