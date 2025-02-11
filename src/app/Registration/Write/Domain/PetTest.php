<?php

namespace App\Registration\Write\Domain;

use Mockery;
use Generator;
use Carbon\Carbon;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Shared\Exceptions\BadOperationException;

class PetTest extends TestCase
{
    public static function stubPetWithoutBreed(): Generator
    {
        yield [
            new Pet(
                petType: PetTypes::Dog,
                petBreed: null,
                breedMix: "",
                name: "Miquette",
                gender: PetGenders::Female,
                dateOfBirth: null,
                estimatedAge: 17
            )
        ];
    }

    public static function stubPetOfNonDangerousBreed(): Generator
    {
        $anyNonDangerousBreed = Mockery::mock(PetBreed::class);
        $anyNonDangerousBreed->shouldReceive("isDangerous")->andReturn(false);

        yield [
            new Pet(
                petType: PetTypes::Dog,
                petBreed: $anyNonDangerousBreed,
                breedMix: "",
                name: "Kiwi",
                gender: PetGenders::Female,
                dateOfBirth: Carbon::parse("2020-02-16"),
                estimatedAge: null
            )
        ];
    }

    public static function stubPetOfDangerousBreed(): Generator
    {
        $anyDangerousBreed = Mockery::mock(PetBreed::class);
        $anyDangerousBreed->shouldReceive("isDangerous")->andReturn(true);

        yield [
            new Pet(
                petType: PetTypes::Dog,
                petBreed: $anyDangerousBreed,
                breedMix: "",
                name: "Shadow",
                gender: PetGenders::Male,
                dateOfBirth: null,
                estimatedAge: 4
            )
        ];
    }

    public static function stubPetOfMissingDateOfBirthData(): Generator
    {
        yield [
            new Pet(
                petType: PetTypes::Dog,
                petBreed: Mockery::mock(PetBreed::class),
                breedMix: "",
                name: "Miquette",
                gender: PetGenders::Female,
                dateOfBirth: null,
                estimatedAge: null
            )
        ];
    }

    public static function stubPetOfKnownBirthDate(): Generator
    {
        yield [
            new Pet(
                petType: PetTypes::Dog,
                petBreed: Mockery::mock(PetBreed::class),
                breedMix: "",
                name: "Kiwi",
                gender: PetGenders::Female,
                dateOfBirth: Carbon::parse("2020-02-16"),
                estimatedAge: null
            )
        ];
    }

    public static function stubPetOfEstimatedAge(): Generator
    {
        yield [
            new Pet(
                petType: PetTypes::Dog,
                petBreed: Mockery::mock(PetBreed::class),
                breedMix: "",
                name: "Shadow",
                gender: PetGenders::Male,
                dateOfBirth: null,
                estimatedAge: 4
            )
        ];
    }

    #[Test]
    #[Group("unit")]
    #[DataProvider("stubPetWithoutBreed")]
    public function isDangerousReturnsFalseWhenNoBreed(Pet $stubPetWithoutBreed): void
    {
        $this->assertFalse($stubPetWithoutBreed->isDangerous());
    }

    #[Test]
    #[Group("unit")]
    #[DataProvider("stubPetOfNonDangerousBreed")]
    public function isDangerousReturnsFalseIfBreedIsNotDangerous(Pet $stubPetOfNonDangerousBreed): void
    {
        $this->assertFalse($stubPetOfNonDangerousBreed->isDangerous());
    }

    #[Test]
    #[Group("unit")]
    #[DataProvider("stubPetOfDangerousBreed")]
    public function isDangerousReturnsTrueIfBreedIsDangerous(Pet $stubPetOfDangerousBreed): void
    {
        $this->assertTrue($stubPetOfDangerousBreed->isDangerous());
    }

    #[Test]
    #[Group("unit")]
    #[DataProvider("stubPetOfMissingDateOfBirthData")]
    public function getDateOfBirthThrowsExeceptionWhenMissingData(Pet $stubPetOfMissingDateOfBirthData): void
    {
        $action = fn() => $stubPetOfMissingDateOfBirthData->getDateOfBirth();

        $this->assertThrows($action, BadOperationException::class);
    }

    #[Test]
    #[Group("unit")]
    #[DataProvider("stubPetOfKnownBirthDate")]
    public function getDateOfBirthReturnsKnownDateOfBirthIfDefined(Pet $stubPetOfKnownBirthDate): void
    {
        $actual = $stubPetOfKnownBirthDate->getDateOfBirth();

        $this->assertEquals("2020-02-16", $actual->format("Y-m-d"));
    }

    #[Test]
    #[Group("integration")]
    #[DataProvider("stubPetOfEstimatedAge")]
    public function getDateOfBirthGivesDateForEstimatedAge(Pet $stubPetOfEstimatedAge): void
    {
        Carbon::setTestNow(Carbon::parse("2025-02-11"));

        $actual = $stubPetOfEstimatedAge->getDateOfBirth();

        $this->assertEquals("2021-02-11", $actual->format("Y-m-d"));
    }
}