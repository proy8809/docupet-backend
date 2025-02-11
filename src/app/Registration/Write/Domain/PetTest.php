<?php

namespace App\Registration\Write\Domain;

use Mockery;
use Generator;
use Carbon\Carbon;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\DataProvider;

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
                dateOfBirth: Mockery::mock(PetDateOfBirth::class),
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
                dateOfBirth: Mockery::mock(PetDateOfBirth::class),
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
                dateOfBirth: Mockery::mock(PetDateOfBirth::class),
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
}