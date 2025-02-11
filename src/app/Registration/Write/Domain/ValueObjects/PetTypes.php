<?php

namespace App\Registration\Write\Domain\ValueObjects;

enum PetTypes: string
{
    case Cat = "cat";
    case Dog = "dog";
}