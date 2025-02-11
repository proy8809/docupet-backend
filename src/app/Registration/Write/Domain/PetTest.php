<?php

namespace App\Registration\Write\Domain;

use Mockery;
use Generator;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Registration\Write\Domain\ValueObjects\PetBreed;
use App\Registration\Write\Domain\ValueObjects\PetTypes;
use App\Registration\Write\Domain\ValueObjects\PetGenders;
use App\Registration\Write\Domain\ValueObjects\PetDateOfBirth;
use App\Registration\Write\Domain\Specifications\PetDangerosity\DangerousBreeds;

class PetTest extends TestCase
{
    public static function stubCat(): Generator
    {
        yield [
            new Pet(
                petName: "Cc",
                petGender: PetGenders::Female,
                petDateOfBirth: Mockery::mock(PetDateOfBirth::class),
                petType: PetTypes::Cat,
                petBreed: new PetBreed("russian_blue"),
                petBreedMix: ""
            )
        ];
    }

    public static function stubDogOfNoBreed(): Generator
    {
        yield [
            new Pet(
                petName: "Miquette",
                petGender: PetGenders::Female,
                petDateOfBirth: Mockery::mock(PetDateOfBirth::class),
                petType: PetTypes::Dog,
                petBreed: null,
                petBreedMix: ""
            )
        ];
    }

    public static function stubDogOfNonDangerousBreed(): Generator
    {
        yield [
            new Pet(
                petName: "Kiwi",
                petGender: PetGenders::Female,
                petDateOfBirth: Mockery::mock(PetDateOfBirth::class),
                petType: PetTypes::Dog,
                petBreed: new PetBreed("samoyed"),
                petBreedMix: ""
            )
        ];
    }

    public static function stubDogOfDangerousBreed(): Generator
    {
        yield [
            new Pet(
                petName: "Shadow",
                petGender: PetGenders::Male,
                petDateOfBirth: Mockery::mock(PetDateOfBirth::class),
                petType: PetTypes::Dog,
                petBreed: new PetBreed(DangerousBreeds::GermanShepherd->value),
                petBreedMix: ""
            )
        ];
    }

    #[Test]
    #[Group("integration")]
    #[DataProvider("stubCat")]
    public function itReturnsFalseWhenPetIsCat(Pet $stubCat): void
    {
        $this->assertFalse($stubCat->isDangerous());
    }

    #[Test]
    #[Group("integration")]
    #[DataProvider("stubDogOfNoBreed")]
    public function itReturnsFalseWhenPetIsDogOfNoBreed(Pet $stubDogWithNoBreed): void
    {
        $this->assertFalse($stubDogWithNoBreed->isDangerous());
    }

    #[Test]
    #[Group("integration")]
    #[DataProvider("stubDogOfNonDangerousBreed")]
    public function itReturnsFalseWhenPetIsDogOfNonDangerousBreed(Pet $stubDogOfNonDangerousBreed): void
    {
        $this->assertFalse($stubDogOfNonDangerousBreed->isDangerous());
    }

    #[Test]
    #[Group("integration")]
    #[DataProvider("stubDogOfDangerousBreed")]
    public function itReturnsTrueWhenPetIsDogOfDangerousBreed(Pet $stubDogOfDangerousBreed): void
    {
        $this->assertTrue($stubDogOfDangerousBreed->isDangerous());
    }
}