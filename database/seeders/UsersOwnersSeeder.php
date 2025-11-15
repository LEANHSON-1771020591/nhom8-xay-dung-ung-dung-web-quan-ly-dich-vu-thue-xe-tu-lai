<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UsersOwnersSeeder extends Seeder
{
    public function run(): void
    {
        $totalUsers = 600;
        $totalOwners = 100;

        for ($i = 1; $i <= $totalUsers; $i++) {
            $name = 'User '.$i;
            User::create([
                'name' => $name,
                'email' => 'user'.$i.'@example.com',
                'password' => bcrypt('password'.$i),
                'avatar' => 'https://via.placeholder.com/80',
                'slug' => Str::slug($name),
                'role' => 'user',
            ]);
        }

        for ($i = 1; $i <= $totalOwners; $i++) {
            $name = 'Owner '.$i;
            User::create([
                'name' => $name,
                'email' => 'owner'.$i.'@example.com',
                'password' => bcrypt('password'.$i),
                'avatar' => 'https://via.placeholder.com/80',
                'slug' => Str::slug($name),
                'role' => 'owner',
            ]);
        }
    }
}

