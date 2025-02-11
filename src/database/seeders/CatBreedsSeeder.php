<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatBreedsSeeder extends Seeder
{
    private const TYPE_KEY = "cat";

    public function run(): void
    {
        $catType = DB::table("pet_types")->where(["key" => self::TYPE_KEY])->first(["id"]);

        if (isset($catType) === false) {
            return;
        }

        $breedBaseData = ["pet_type_id" => $catType->id];

        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "american_bobtail"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "bengal"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "chartreux"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "foldex"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "scottish_fold"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "russian_blue"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "siamese"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "siberian"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "thai"]);
    }
}
