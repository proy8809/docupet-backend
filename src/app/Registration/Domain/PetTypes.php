<?php

namespace App\Registration\Domain;

enum PetTypes: string
{
    case Cat = "cat";
    case Dog = "dog";
}