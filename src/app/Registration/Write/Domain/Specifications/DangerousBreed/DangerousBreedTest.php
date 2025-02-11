<?php

namespace App\Registration\Write\Domain\Specifications\DangerousBreed;

use Mockery;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use App\Registration\Write\Domain\ValueObjects\CatBreed;
use App\Registration\Write\Domain\ValueObjects\DogBreed;

class DangerousBreedTest extends TestCase
{
    #[Test]
    #[Group("unit")]
    public function itReturnsFalseForCatBreed(): void
    {
        $stubCatBreed = Mockery::mock(CatBreed::class);

        $this->assertFalse(new DangerousBreed()->isSatisfiedBy($stubCatBreed));
    }

    #[Test]
    #[Group("unit")]
    public function itReturnsFalseForNonDangerousDogBreed(): void
    {
        $stubNonDangerousDogBreed = Mockery::mock(DogBreed::class);
        $stubNonDangerousDogBreed->shouldReceive("getValue")->andReturn("samoyed");

        $this->assertFalse(new DangerousBreed()->isSatisfiedBy($stubNonDangerousDogBreed));
    }

    #[Test]
    #[Group("unit")]
    public function isReturnsTrueForDangerousDogBreed(): void
    {
        $anyDangerousDogBreed = DangerousDogBreeds::AmericanPitbull->value;

        $stubDangerousDogBreed = Mockery::mock(DogBreed::class);
        $stubDangerousDogBreed->shouldReceive("getValue")->andReturn($anyDangerousDogBreed);

        $this->assertTrue(new DangerousBreed()->isSatisfiedBy($stubDangerousDogBreed));
    }
}