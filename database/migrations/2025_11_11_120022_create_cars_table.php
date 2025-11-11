<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("address");
            $table->string("location");
            $table->string("price");
            $table->string("images");
            $table->string("desc");
            $table->string("model");
            $table->string("transmission");
            $table->string("fuel");
            $table->string("consumed");
            $table->int("trip");
            $table->int("seat");
            $table->int("owner_id");
            $table->string("slug");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
