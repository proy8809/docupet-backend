<?php

namespace App\Registration\Presentation;

use Carbon\Carbon;
use Tests\TestCase;
use App\Shared\Eloquent\Pet;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Shared\Eloquent\PetType as PetTypeEloquent;
use App\Shared\Eloquent\PetBreed as PetBreedEloquent;

class PetControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group("e2e")]
    public function itReturns201WhenSaved(): void
    {
        $petTypeEloquent = PetTypeEloquent::create(["key" => "dog"]);
        PetBreedEloquent::create(["pet_type_id" => $petTypeEloquent->id, "key" => "samoyed"]);

        $response = $this->json("post", "api/pets", [
            "name" => "Kiwi",
            "gender" => "f",
            "date_of_birth" => "2020-02-16",
            "estimated_age" => null,
            "type" => "dog",
            "breed" => "samoyed",
            "breed_mix" => ""
        ]);

        $response->assertStatus(201);
    }

    #[Test]
    #[Group("e2e")]
    public function itReturns422WhenInvalidRequest(): void
    {
        $petTypeEloquent = PetTypeEloquent::create(["key" => "dog"]);
        PetBreedEloquent::create(["pet_type_id" => $petTypeEloquent->id, "key" => "samoyed"]);

        $response = $this->json("post", "api/pets", []);

        $response->assertStatus(422);
    }


    #[Test]
    #[Group("e2e")]
    public function itReturnsProperSummary(): void
    {
        Carbon::setTestNow(Carbon::parse("2025-02-11"));

        $petTypeEloquent = PetTypeEloquent::create(["key" => "dog"]);
        PetBreedEloquent::create(["pet_type_id" => $petTypeEloquent->id, "key" => "samoyed"]);

        $response = $this->json("post", "api/pets", [
            "name" => "Kiwi",
            "gender" => "f",
            "date_of_birth" => "2020-02-16",
            "estimated_age" => null,
            "type" => "dog",
            "breed" => "samoyed",
            "breed_mix" => ""
        ]);

        $response->assertJsonFragment([
            "name" => "Kiwi",
            "age" => 4,
            "gender" => "f",
            "type" => "dog",
            "breed" => "samoyed",
            "breed_mix" => "",
            "is_dangerous" => false
        ]);
    }
}