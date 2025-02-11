<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pet_breeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pet_type_id");
            $table->string("key", 64);

            $table->foreign("pet_type_id")->references("id")->on("pet_types")->onDelete("cascade");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pet_breeds');
    }
};
