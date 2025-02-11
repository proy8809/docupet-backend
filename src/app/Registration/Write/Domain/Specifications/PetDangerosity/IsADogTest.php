<?php

namespace App\Registration\Write\Domain\Specifications\PetDangerosity;

use Mockery;
use Tests\TestCase;
use App\Registration\Write\Domain\Pet;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use App\Registration\Write\Domain\ValueObjects\PetTypes;
use App\Registration\Write\Domain\Specifications\PetDangerosity\IsADog;

class IsADogTest extends TestCase
{
    #[Test]
    #[Group("unit")]
    public function itReturnsTrueWhenPetIsADog(): void
    {
        $stubPet = Mockery::mock(Pet::class);
        $stubPet->shouldReceive("getPetType")->andReturn(PetTypes::Dog);

        $this->assertTrue(new IsADog()->isSatisfiedBy($stubPet));
    }

    #[Test]
    #[Group("unit")]
    public function itReturnsFalseWhenPetIsNotADog(): void
    {
        $stubPet = Mockery::mock(Pet::class);
        $stubPet->shouldReceive("getPetType")->andReturn(PetTypes::Cat);

        $this->assertFalse(new IsADog()->isSatisfiedBy($stubPet));
    }
}