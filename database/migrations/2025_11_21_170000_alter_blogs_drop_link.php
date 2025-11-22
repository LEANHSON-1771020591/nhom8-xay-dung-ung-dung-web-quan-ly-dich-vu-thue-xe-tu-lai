<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('ALTER TABLE blogs DROP COLUMN link');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE blogs ADD COLUMN link VARCHAR(255) NULL');
    }
};