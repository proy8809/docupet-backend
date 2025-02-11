<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DogBreedsSeeder extends Seeder
{
    private const TYPE_KEY = "dog";

    public function run(): void
    {
        $dogType = DB::table("pet_types")->where(["key" => self::TYPE_KEY])->first(["id"]);

        if (isset($dogType) === false) {
            return;
        }

        $breedBaseData = ["pet_type_id" => $dogType->id];

        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "afghan_hound"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "akita"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "american_pitbull_terrier"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "beauceron"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "borzoi"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "bullmastiff"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "chihuahua"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "german_shepherd"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "golden_retriever"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "rottweiler"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "samoyed"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "siberian_husky"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "taiwan_dog"]);
        DB::table("pet_breeds")->insert([...$breedBaseData, "key" => "whippet"]);
    }
}
