<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->index();
            $table->boolean('is_locked')->default(false)->index();
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->string('status')->default('approved')->index();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_role_index');
            $table->dropIndex('users_is_locked_index');
            $table->dropColumn(['role','is_locked']);
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex('cars_status_index');
            $table->dropColumn('status');
        });
    }
};

