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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('bookings')->truncate();
        DB::table('cars')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $faker = \Faker\Factory::create('vi_VN');

        for ($i = 0; $i < 100; $i++) {
            $name = trim($faker->firstName() . ' ' . $faker->lastName());
            $email = Str::slug($name) . Str::random(4) . '@gmail.com';
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('name123'),
                'avatar' => 'https://i.pravatar.cc/80?img=' . $faker->numberBetween(1, 70),
                'slug' => Str::slug($name) . '-' . Str::random(6),
                'role' => 'user',
                'is_locked' => false,
            ]);
        }

        for ($i = 0; $i < 50; $i++) {
            $name = trim($faker->firstName() . ' ' . $faker->lastName());
            $email = Str::slug($name) . Str::random(4) . '@gmail.com';
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('name123'),
                'avatar' => 'https://i.pravatar.cc/80?img=' . $faker->numberBetween(1, 70),
                'slug' => Str::slug($name) . '-' . Str::random(6),
                'role' => 'owner',
                'is_locked' => false,
            ]);
        }

        $this->call([
            CarMiotoSeeder::class,
        ]);
    }
}
