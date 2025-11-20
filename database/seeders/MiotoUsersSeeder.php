<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\User;

class MiotoUsersSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/mioto_users.json');
        if (!File::exists($path)) {
            return;
        }
        $json = File::get($path);
        $items = collect(json_decode($json, true));
        $items->each(function ($u) {
            $name = $u['username'] ?? ($u['name'] ?? 'Người dùng');
            $avatar = $u['user_img'] ?? ($u['avatar'] ?? 'https://via.placeholder.com/80');
            $slug = Str::slug($name);
            $identifier = $u['mioto_user_id'] ?? ($u['id'] ?? Str::random(6));
            $email = 'mioto_'.$slug.'_'.$identifier.'@import.local';
            $role = 'owner';
            if (!User::where('email', $email)->exists()) {
                User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt('secret123'),
                    'avatar' => $avatar,
                    'slug' => $slug,
                    'role' => $role,
                    'is_locked' => false,
                ]);
            }
        });
    }
}