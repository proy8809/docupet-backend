<?php

namespace App\Registration\Write\Domain\Services;

use Mockery;
use Generator;
use Tests\TestCase;
use App\Registration\Write\Domain\Pet;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Registration\Write\Domain\ValueObjects\PetBreed;
use App\Registration\Write\Domain\ValueObjects\PetTypes;
use App\Registration\Write\Domain\ValueObjects\PetGenders;
use App\Registration\Write\Domain\ValueObjects\PetDateOfBirth;
use App\Registration\Write\Domain\Specifications\PetDangerosity\DangerousBreeds;

class PetDangerosityServiceTest extends TestCase
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
    #[Group("unit")]
    #[DataProvider("stubCat")]
    public function itReturnsFalseWhenPetIsCat(Pet $stubCat): void
    {
        $service = app(PetDangerosityService::class);
        $this->assertFalse($service->isDangerous($stubCat));
    }

    #[Test]
    #[Group("unit")]
    #[DataProvider("stubDogOfNoBreed")]
    public function itReturnsFalseWhenPetIsDogOfNoBreed(Pet $stubDogWithNoBreed): void
    {
        $service = app(PetDangerosityService::class);
        $this->assertFalse($service->isDangerous($stubDogWithNoBreed));
    }

    #[Test]
    #[Group("unit")]
    #[DataProvider("stubDogOfNonDangerousBreed")]
    public function itReturnsFalseWhenPetIsDogOfNonDangerousBreed(Pet $stubDogOfNonDangerousBreed): void
    {
        $service = app(PetDangerosityService::class);
        $this->assertFalse($service->isDangerous($stubDogOfNonDangerousBreed));
    }

    #[Test]
    #[Group("unit")]
    #[DataProvider("stubDogOfDangerousBreed")]
    public function itReturnsTrueWhenPetIsDogOfDangerousBreed(Pet $stubDogOfDangerousBreed): void
    {
        $service = app(PetDangerosityService::class);
        $this->assertTrue($service->isDangerous($stubDogOfDangerousBreed));
    }
}