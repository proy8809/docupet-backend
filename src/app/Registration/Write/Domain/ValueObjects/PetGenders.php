<?php

namespace App\Registration\Write\Domain\ValueObjects;

enum PetGenders: string
{
    case Male = "m";
    case Female = "f";
}