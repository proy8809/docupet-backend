<?php

namespace App\Registration\Write\Domain;

use Mockery;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use App\Shared\Exceptions\BadOperationException;
use App\Registration\Write\Domain\ValueObjects\PetTypes;
use App\Registration\Write\Domain\ValueObjects\PetGenders;
use App\Registration\Write\Domain\Services\PetDangerosityService;

class PetFactoryTest extends TestCase
{
    #[Test]
    #[Group("unit")]
    public function itThrowsExceptionWhenPetTypeIsInvalid(): void
    {
        $stubPetDangerosityService = Mockery::spy(PetDangerosityService::class);

        $factory = new PetFactory($stubPetDangerosityService);

        $action = fn() => $factory->fromPrimitives(
            petNameValue: "Kiwi",
            petGenderValue: PetGenders::Female->value,
            petDateOfBirthValue: "2020-02-16",
            petEstimatedAgeValue: null,
            petTypeValue: "oppossum",
            petBreedValue: "samoyed",
            petBreedMixValue: "",
        );

        $this->assertThrows($action, BadOperationException::class);
    }

    #[Test]
    #[Group("unit")]
    public function itThrowsExceptionWhenPetGenderIsInvalid(): void
    {
        $stubPetDangerosityService = Mockery::spy(PetDangerosityService::class);

        $factory = new PetFactory($stubPetDangerosityService);

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
        $stubPetDangerosityService = Mockery::spy(PetDangerosityService::class);

        $factory = new PetFactory($stubPetDangerosityService);

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

    #[Test]
    #[Group("unit")]
    public function itReconstitutesPetAggregate(): void
    {
        $stubPetDangerosityService = Mockery::mock(PetDangerosityService::class);
        $stubPetDangerosityService->shouldReceive("isDangerous")->andReturn(false);

        $factory = new PetFactory($stubPetDangerosityService);

        $pet = $factory->fromPrimitives(
            petNameValue: "Kiwi",
            petGenderValue: PetGenders::Female->value,
            petDateOfBirthValue: "2020-02-16",
            petEstimatedAgeValue: null,
            petTypeValue: PetTypes::Dog->value,
            petBreedValue: "samoyed",
            petBreedMixValue: ""
        );

        $this->assertEquals("Kiwi", $pet->getPetName());
        $this->assertEquals(PetGenders::Female, $pet->getPetGender());
        $this->assertEquals("2020-02-16", (string) $pet->getPetDateOfBirth());
        $this->assertEquals(PetTypes::Dog, $pet->getPetType());
        $this->assertEquals("samoyed", (string) $pet->getPetBreed());
        $this->assertEmpty($pet->getPetBreedMix());
        $this->assertFalse($pet->isDangerous());
    }
}