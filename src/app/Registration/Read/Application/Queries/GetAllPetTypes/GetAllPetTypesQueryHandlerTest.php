<?php

namespace App\Registration\Read\Application\Queries\GetAllPetTypes;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Shared\Eloquent\PetType as PetTypeEloquent;

class GetAllPetTypesQueryHandlerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group("integration")]
    public function itReturnsAllPetTypeKeys(): void
    {
        PetTypeEloquent::create(["key" => "cat"]);
        PetTypeEloquent::create(["key" => "dog"]);

        $handler = new GetAllPetTypesQueryHandler();
        $petTypes = $handler->handle();

        $this->assertEquals(["cat", "dog"], $petTypes);
    }
}