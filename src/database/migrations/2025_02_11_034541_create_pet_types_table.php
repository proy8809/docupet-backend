<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pet_types', function (Blueprint $table) {
            $table->id();
            $table->string("key", length: 16);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pet_types');
    }
};
