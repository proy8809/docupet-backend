<?php

namespace App\Registration\Read\Application\Queries\GetPetSummary;

use Carbon\Carbon;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use App\Shared\Eloquent\Pet as PetEloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Shared\Eloquent\PetType as PetTypeEloquent;
use App\Shared\Exceptions\ResourceNotFoundException;
use App\Shared\Eloquent\PetBreed as PetBreedEloquent;
use App\Registration\Read\Application\Queries\GetPetSummary\GetPetSummaryQueryHandler;

class GetPetSummaryQueryHandlerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group("integration")]
    public function itReturnsPetSummaryWithAccurateValues(): void
    {
        Carbon::setTestNow(Carbon::parse("2025-02-11"));

        $petTypeEloquent = PetTypeEloquent::create(["key" => "cat"]);
        $petBreedEloquent = PetBreedEloquent::create([
            "pet_type_id" => $petTypeEloquent->id,
            "key" => "samoyed"
        ]);

        $petEloquent = PetEloquent::create([
            "name" => "Kiwi",
            "date_of_birth" => Carbon::parse("2020-02-16")->unix(),
            "gender" => "f",
            "pet_type_id" => $petTypeEloquent->id,
            "pet_breed_id" => $petBreedEloquent->id,
            "breed_mix" => "cross breed",
            "is_dangerous" => false
        ]);

        $handler = new GetPetSummaryQueryHandler();
        $petSummary = $handler->handle($petEloquent->id);

        $this->assertEquals("Kiwi", $petSummary->petName);
        $this->assertEquals(4, $petSummary->petAge);
        $this->assertEquals("f", $petSummary->petGender);
        $this->assertEquals("cat", $petSummary->petType);
        $this->assertEquals("samoyed", $petSummary->petBreed);
        $this->assertEquals("cross breed", $petSummary->petBreedMix);
        $this->assertFalse($petSummary->isDangerous);
    }

    #[Test]
    #[Group("integration")]
    public function itThrowsExceptionWhenPetNotFound(): void
    {
        $handler = new GetPetSummaryQueryHandler();
        $action = fn() => $handler->handle(1);

        $this->assertThrows($action, ResourceNotFoundException::class);
    }

}