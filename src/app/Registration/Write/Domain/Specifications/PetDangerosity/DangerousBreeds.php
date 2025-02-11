<?php

namespace App\Registration\Write\Domain\Specifications\PetDangerosity;

use App\Registration\Write\Domain\ValueObjects\PetBreed;

enum DangerousBreeds: string
{
    case AmericanPitbullTerrier = "american_pitbull_terrier";
    case Bullmastiff = "bullmastiff";
    case GermanShepherd = "german_shepherd";
    case Rottweiler = "rottweiler";

    /**
     * @return array<PetBreed>
     */
    public static function toBreeds(): array
    {
        $dangerousBreeds = array_column(self::cases(), "value");

        return array_map(
            fn(string $dangerousBreed) => new PetBreed($dangerousBreed),
            $dangerousBreeds
        );
    }
}