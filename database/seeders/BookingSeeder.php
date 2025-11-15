<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
                'avatar' => 'https://via.placeholder.com/80',
                'slug' => 'demo-user',
            ]);
        }

        $cars = Car::take(4)->get();
        $start = Carbon::now()->startOfDay();

        foreach ($cars as $i => $car) {
            Booking::create([
                'user_id' => $user->id,
                'car_id' => $car->id,
                'start_date' => $start->copy()->addDays($i)->toDateString(),
                'end_date' => $start->copy()->addDays($i + 2)->toDateString(),
                'daily_price' => (int)$car->price,
                'status' => 'confirmed',
            ]);
        }
    }
}
