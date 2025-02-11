<?php

namespace App\Registration\Write\Domain;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use App\Shared\Exceptions\BadOperationException;
use App\Registration\Write\Domain\ValueObjects\PetTypes;
use App\Registration\Write\Domain\ValueObjects\PetGenders;

class PetFactoryTest extends TestCase
{
    #[Test]
    #[Group("unit")]
    public function itThrowsExceptionWhenPetTypeIsInvalid(): void
    {
        $factory = new PetFactory();

        $action = fn() => $factory->fromPrimitives(
            petNameValue: "Kiwi",
            petGenderValue: PetGenders::Female->value,
            petDateOfBirthValue: "2020-02-16",
            petEstimatedAgeValue: null,
            petTypeValue: "oppossum",
            petBreedValue: "samoyed",
            petBreedMixValue: ""
        );

        $this->assertThrows($action, BadOperationException::class);
    }

    #[Test]
    #[Group("unit")]
    public function itThrowsExceptionWhenPetGenderIsInvalid(): void
    {
        $factory = new PetFactory();

        $action = fn() => $factory->fromPrimitives(
            petNameValue: "Kiwi",
            petGenderValue: "a",
            petDateOfBirthValue: "2020-02-16",
            petEstimatedAgeValue: null,
            petTypeValue: PetTypes::Dog->value,
            petBreedValue: "samoyed",
            petBreedMixValue: ""
        );

        $this->assertThrows($action, BadOperationException::class);
    }

    #[Test]
    #[Group("unit")]
    public function itThrowsExceptionWhenMissingBirthData(): void
    {
        $factory = new PetFactory();

        $action = fn() => $factory->fromPrimitives(
            petNameValue: "Kiwi",
            petGenderValue: PetGenders::Female->value,
            petDateOfBirthValue: null,
            petEstimatedAgeValue: null,
            petTypeValue: PetTypes::Dog->value,
            petBreedValue: "samoyed",
            petBreedMixValue: ""
        );

        $this->assertThrows($action, BadOperationException::class);
    }
}