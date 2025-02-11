<?php

namespace App\Registration\Write\Domain\Specifications\PetDangerosity;

use Mockery;
use Tests\TestCase;
use App\Registration\Write\Domain\Pet;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use App\Registration\Write\Domain\ValueObjects\PetBreed;
use App\Registration\Write\Domain\Specifications\PetDangerosity\DangerousBreeds;
use App\Registration\Write\Domain\Specifications\PetDangerosity\IsADangerousBreed;

class IsADangerousBreedTest extends TestCase
{
    #[Test]
    #[Group("unit")]
    public function itReturnsTrueWhenPetIsADangerousBreed(): void
    {
        $anyDangerousBreed = new PetBreed(DangerousBreeds::AmericanPitbullTerrier->value);

        $stubPet = Mockery::mock(Pet::class);
        $stubPet->shouldReceive("getPetBreed")->andReturn($anyDangerousBreed);

        $this->assertTrue(new IsADangerousBreed()->isSatisfiedBy($stubPet));
    }

    #[Test]
    #[Group("unit")]
    public function itReturnsFalseWhenPetIsNotADangerousBreed(): void
    {
        $anyNonDangerousBreed = new PetBreed("samoyed");

        $stubPet = Mockery::mock(Pet::class);
        $stubPet->shouldReceive("getPetBreed")->andReturn($anyNonDangerousBreed);

        $this->assertFalse(new IsADangerousBreed()->isSatisfiedBy($stubPet));
    }

    #[Test]
    #[Group("unit")]
    public function itReturnsFalseWhenPetHasNoBreed(): void
    {
        $stubPet = Mockery::mock(Pet::class);
        $stubPet->shouldReceive("getPetBreed")->andReturnNull();

        $this->assertFalse(new IsADangerousBreed()->isSatisfiedBy($stubPet));
    }
}