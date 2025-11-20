<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class ResetDataSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        } else {
            DB::statement('PRAGMA foreign_keys = OFF');
        }
        if (DB::getDriverName() === 'mysql') {
            DB::table('bookings')->truncate();
            DB::table('cars')->truncate();
            DB::table('users')->truncate();
        } else {
            DB::table('bookings')->delete();
            DB::table('cars')->delete();
            DB::table('users')->delete();
        }
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } else {
            DB::statement('PRAGMA foreign_keys = ON');
        }

        $this->call([
            MiotoUsersSeeder::class,
            CarMiotoSeeder::class,
        ]);
    }
}
