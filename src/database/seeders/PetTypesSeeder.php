<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("pet_types")->insert(["key" => "cat"]);
        DB::table("pet_types")->insert(["key" => "dog"]);
    }
}
