<?php

namespace App\Registration\Write\Domain\Specifications;

use App\Registration\Write\Domain\Pet;

interface SpecificationInterface
{
    public function isSatisfiedBy(Pet $pet): bool;

    public function and(self $petSpecification): self;
}