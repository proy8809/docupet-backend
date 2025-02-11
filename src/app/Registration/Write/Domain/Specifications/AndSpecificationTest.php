<?php

namespace App\Registration\Write\Domain\Specifications;

use Mockery;
use Tests\TestCase;
use App\Registration\Write\Domain\Pet;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;

class AndSpecificationTest extends TestCase
{
    #[Test]
    #[Group("unit")]
    public function itReturnsTrueWhenBothAreSatisfied(): void
    {
        $stubSpecifications = [
            Mockery::mock(SpecificationInterface::class),
            Mockery::mock(SpecificationInterface::class),
        ];

        $stubSpecifications[0]->shouldReceive("isSatisfiedBy")->andReturn(true);
        $stubSpecifications[1]->shouldReceive("isSatisfiedBy")->andReturn(true);

        $andSpecification = new AndSpecification($stubSpecifications[0], $stubSpecifications[1]);

        $anyPet = Mockery::mock(Pet::class);

        $this->assertTrue($andSpecification->isSatisfiedBy($anyPet));
    }

    #[Test]
    #[Group("unit")]
    public function itReturnsFalseWhenOneIsNotSatisfied(): void
    {
        $stubSpecifications = [
            Mockery::mock(SpecificationInterface::class),
            Mockery::mock(SpecificationInterface::class),
        ];

        $stubSpecifications[0]->shouldReceive("isSatisfiedBy")->andReturn(true);
        $stubSpecifications[1]->shouldReceive("isSatisfiedBy")->andReturn(false);

        $andSpecification = new AndSpecification($stubSpecifications[0], $stubSpecifications[1]);

        $anyPet = Mockery::mock(Pet::class);

        $this->assertFalse($andSpecification->isSatisfiedBy($anyPet));
    }
}