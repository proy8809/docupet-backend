<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([PetTypesSeeder::class]);
        $this->call([CatBreedsSeeder::class]);
        $this->call([DogBreedsSeeder::class]);

    }
}
