<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasColumn('blogs', 'mioto_id')) {
            try {
                DB::statement('ALTER TABLE blogs DROP INDEX blogs_mioto_id_index');
            } catch (\Exception $e) {
            }
            Schema::table('blogs', function (Blueprint $table) {
                $table->dropColumn('mioto_id');
            });
        }
        
        if (Schema::hasColumn('blogs', 'vato_id')) {
            try {
                DB::statement('ALTER TABLE blogs DROP INDEX blogs_vato_id_index');
            } catch (\Exception $e) {
            }
            Schema::table('blogs', function (Blueprint $table) {
                $table->dropColumn('vato_id');
            });
        }
    }

    public function down(): void
    {
    }
};

