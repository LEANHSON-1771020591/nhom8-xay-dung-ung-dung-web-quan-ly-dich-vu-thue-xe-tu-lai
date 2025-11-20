<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            if (!$this->indexExists('cars', 'cars_location_index')) $table->index('location');
            if (!$this->indexExists('cars', 'cars_model_index')) $table->index('model');
            if (!$this->indexExists('cars', 'cars_seat_index')) $table->index('seat');
            if (!$this->indexExists('cars', 'cars_fuel_index')) $table->index('fuel');
            if (!$this->indexExists('cars', 'cars_owner_id_index')) $table->index('owner_id');
            if (!$this->indexExists('cars', 'cars_slug_index')) $table->index('slug');
        });

        Schema::table('bookings', function (Blueprint $table) {
            if (!$this->indexExists('bookings', 'bookings_status_index')) $table->index('status');
            if (!$this->indexExists('bookings', 'bookings_start_date_index')) $table->index('start_date');
            if (!$this->indexExists('bookings', 'bookings_end_date_index')) $table->index('end_date');
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            if ($this->indexExists('cars', 'cars_location_index')) $table->dropIndex('cars_location_index');
            if ($this->indexExists('cars', 'cars_model_index')) $table->dropIndex('cars_model_index');
            if ($this->indexExists('cars', 'cars_seat_index')) $table->dropIndex('cars_seat_index');
            if ($this->indexExists('cars', 'cars_fuel_index')) $table->dropIndex('cars_fuel_index');
            if ($this->indexExists('cars', 'cars_owner_id_index')) $table->dropIndex('cars_owner_id_index');
            if ($this->indexExists('cars', 'cars_slug_index')) $table->dropIndex('cars_slug_index');
        });

        Schema::table('bookings', function (Blueprint $table) {
            if ($this->indexExists('bookings', 'bookings_status_index')) $table->dropIndex('bookings_status_index');
            if ($this->indexExists('bookings', 'bookings_start_date_index')) $table->dropIndex('bookings_start_date_index');
            if ($this->indexExists('bookings', 'bookings_end_date_index')) $table->dropIndex('bookings_end_date_index');
        });
    }

    private function indexExists(string $table, string $index): bool
    {
        if (DB::getDriverName() !== 'mysql') {
            return false;
        }
        $res = DB::select("SELECT 1 FROM information_schema.statistics WHERE table_schema = DATABASE() AND table_name = ? AND index_name = ? LIMIT 1", [$table, $index]);
        return !empty($res);
    }
};
