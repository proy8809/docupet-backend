<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pet_type_id");
            $table->unsignedBigInteger("pet_breed_id");
            $table->string("breed_mix", 128);
            $table->string("name", 32);
            $table->enum("gender", ["m", "f"]);
            $table->timestamp("date_of_birth");
            $table->boolean("is_dangerous");

            $table->foreign("pet_type_id")->references("id")->on("pet_types");
            $table->foreign("pet_breed_id")->references("id")->on("pet_breeds");

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
