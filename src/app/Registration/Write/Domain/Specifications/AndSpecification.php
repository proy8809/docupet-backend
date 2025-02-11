<?php

namespace App\Registration\Write\Domain\Specifications;

use App\Registration\Write\Domain\Pet;

class AndSpecification extends Specification
{
    public function __construct(
        private readonly SpecificationInterface $leftSpecification,
        private readonly SpecificationInterface $rightSpecification
    ) {
    }

    public function isSatisfiedBy(Pet $pet): bool
    {
        return $this->leftSpecification->isSatisfiedBy($pet) &&
            $this->rightSpecification->isSatisfiedBy($pet);
    }
}