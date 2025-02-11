<?php

namespace App\Registration\Domain\Specifications;

enum DangerousDogBreeds: string
{
    case AmericanPitbull = "american_pitbull_terrier";
    case BullMastiff = "bullmastiff";
    case GermanShepherd = "german_shepherd";
    case Rottweiler = "rottweiler";
}