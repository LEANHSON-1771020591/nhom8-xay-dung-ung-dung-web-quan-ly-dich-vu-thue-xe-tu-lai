<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('ALTER TABLE cars ADD COLUMN images_new JSON NULL AFTER price');
        DB::statement('UPDATE cars SET images_new = JSON_ARRAY(images)');
        DB::statement('ALTER TABLE cars DROP COLUMN images');
        DB::statement('ALTER TABLE cars CHANGE COLUMN images_new images JSON NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE cars ADD COLUMN images_old VARCHAR(255) NULL AFTER price');
        DB::statement("UPDATE cars SET images_old = JSON_UNQUOTE(JSON_EXTRACT(images, '$[0]'))");
        DB::statement('ALTER TABLE cars DROP COLUMN images');
        DB::statement('ALTER TABLE cars CHANGE COLUMN images_old images VARCHAR(255) NOT NULL');
    }
};

