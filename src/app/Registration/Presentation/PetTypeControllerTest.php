<?php

namespace App\registration\Presentation;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Shared\Eloquent\PetType as PetTypeEloquent;

class PetTypeControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group("e2e")]
    public function itReturns200WhenGettingTypes(): void
    {
        PetTypeEloquent::create(["key" => "cat"]);
        PetTypeEloquent::create(["key" => "dog"]);

        $response = $this->json("get", "api/types");

        $response->assertStatus(200);
    }

    #[Test]
    #[Group("e2e")]
    public function itReturns200WhenGettingBreedsByType(): void
    {
        PetTypeEloquent::create(["key" => "cat"]);
        PetTypeEloquent::create(["key" => "dog"]);

        $response = $this->json("get", "api/types/dog/breeds");

        $response->assertStatus(200);
    }
}