<?php

namespace App\Registration\Write\Domain;

interface PetRepositoryInterface
{
    public function persist(Pet $pet): int;
}