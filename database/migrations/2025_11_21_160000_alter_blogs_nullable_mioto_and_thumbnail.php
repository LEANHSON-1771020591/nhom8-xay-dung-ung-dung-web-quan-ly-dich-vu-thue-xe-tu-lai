<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Make mioto_id nullable to allow admin-created posts without external ID
        DB::statement('ALTER TABLE blogs MODIFY mioto_id VARCHAR(255) NULL');
        // Keep thumbnail as string URL; avoid base64 data URLs exceeding varchar length
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE blogs MODIFY mioto_id VARCHAR(255) NOT NULL');
    }
};