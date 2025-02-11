<?php

namespace App\Registration\Write\Domain\Specifications;

use App\Registration\Write\Domain\Pet;

abstract class Specification implements SpecificationInterface
{
    abstract public function isSatisfiedBy(Pet $pet): bool;

    public function and(SpecificationInterface $otherSpecification): SpecificationInterface
    {
        return new AndSpecification($this, $otherSpecification);
    }
}