<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Car;
use App\Models\Category;
use Illuminate\Support\Str;

class CompleteDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear all existing data
        $this->command->info('Clearing existing data...');
        
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table('bookings')->truncate();
            DB::table('cars')->truncate();
            DB::table('users')->truncate();
            DB::table('categories')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } else {
            DB::statement('PRAGMA foreign_keys = OFF');
            DB::table('bookings')->delete();
            DB::table('cars')->delete();
            DB::table('users')->delete();
            DB::table('categories')->delete();
            DB::statement('PRAGMA foreign_keys = ON');
        }

        // Seed categories
        $this->seedCategories();
        
        // Seed users from mioto_users.json
        $this->seedUsers();
        
        // Seed cars - ensure 600 cars
        $this->seedCars();
        
        $this->command->info('Database seeding completed successfully!');
    }

    private function seedCategories(): void
    {
        $this->command->info('Seeding categories...');
        
        $categories = [
            ['name' => 'Sedan', 'slug' => 'sedan'],
            ['name' => 'SUV', 'slug' => 'suv'],
            ['name' => 'Hatchback', 'slug' => 'hatchback'],
            ['name' => 'Xe điện', 'slug' => 'xe-dien'],
            ['name' => 'Xe tự lái', 'slug' => 'xe-tu-lai'],
            ['name' => 'Gia đình', 'slug' => 'gia-dinh'],
            ['name' => 'Du lịch', 'slug' => 'du-lich'],
            ['name' => 'Công việc', 'slug' => 'cong-viec'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }

    private function seedUsers(): void
    {
        $this->command->info('Seeding users from mioto_users.json...');
        
        $usersPath = database_path('data/mioto_users.json');
        if (!File::exists($usersPath)) {
            $this->command->error('mioto_users.json not found!');
            return;
        }

        $usersData = json_decode(File::get($usersPath), true);
        
        foreach ($usersData as $userData) {
            $name = $userData['username'] ?? 'Người dùng';
            $email = 'mioto_' . Str::slug($name) . '_' . ($userData['mioto_user_id'] ?? $userData['id']) . '@import.local';
            
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt('secret123'),
                'avatar' => $userData['user_img'] ?? 'https://via.placeholder.com/80',
                'slug' => Str::slug($name),
                'role' => 'owner',
                'is_locked' => false,
            ]);
        }
        
        $this->command->info('Created ' . count($usersData) . ' users');
    }

    private function seedCars(): void
    {
        $this->command->info('Seeding cars...');
        
        $carsPath = database_path('data/mioto_cars.json');
        $userCarPath = database_path('data/mioto_user_car.json');
        
        if (!File::exists($carsPath)) {
            $this->command->error('mioto_cars.json not found!');
            return;
        }

        $carsData = json_decode(File::get($carsPath), true);
        $userCarMapping = [];
        
        if (File::exists($userCarPath)) {
            $userCarData = json_decode(File::get($userCarPath), true);
            foreach ($userCarData as $mapping) {
                $userCarMapping[$mapping['mioto_car_id']] = $mapping['mioto_user_id'];
            }
        }

        // Get all users for mapping
        $users = User::all();
        $userIndex = 0;

        // Seed existing 530 cars
        foreach ($carsData as $index => $carData) {
            $this->createCar($carData, $users, $userCarMapping, $userIndex);
        }
        
        $this->command->info('Created ' . count($carsData) . ' cars from JSON');
        
        // Create additional 70 cars to reach 600
        $additionalCars = 70;
        $this->command->info("Creating additional $additionalCars cars to reach 600...");
        
        for ($i = 0; $i < $additionalCars; $i++) {
            $fakeCar = $this->generateFakeCarData($i);
            $this->createCar($fakeCar, $users, $userCarMapping, $userIndex);
        }
        
        $totalCars = count($carsData) + $additionalCars;
        $this->command->info("Total cars created: $totalCars");
    }

    private function createCar($carData, $users, &$userCarMapping, &$userIndex): void
    {
        // Map location
        $location = $this->mapLocation($carData['location'] ?? 'Unknown');
        
        // Map transmission
        $transmission = $this->mapTransmission($carData['transmission'] ?? '');
        
        // Map fuel
        $fuel = $this->mapFuel($carData['fuel'] ?? 'Xăng');
        
        // Parse price
        $price = $this->parsePrice($carData['price'] ?? '0');
        
        // Parse trip
        $trip = $this->parseTrip($carData['trip'] ?? '0');
        
        // Parse seat
        $seat = $this->parseSeat($carData['seat'] ?? '5');
        
        // Find owner
        $ownerId = $this->findOwnerId($carData, $users, $userCarMapping, $userIndex);
        
        // Generate slug
        $slug = Str::slug($carData['model'] ?? 'Unknown') . '-' . Str::random(6);
        
        // Ensure unique slug
        while (Car::where('slug', $slug)->exists()) {
            $slug = Str::slug($carData['model'] ?? 'Unknown') . '-' . Str::random(6);
        }

        // Create car
        Car::create([
            'model' => $carData['model'] ?? 'Unknown',
            'brand' => $carData['brand'] ?? 'Unknown',
            'year' => $carData['year'] ?? 2020,
            'price' => $price,
            'location' => $location,
            'transmission' => $transmission,
            'fuel' => $fuel,
            'trip' => $trip,
            'seat' => $seat,
            'slug' => $slug,
            'owner_id' => $ownerId,
            'images' => json_encode($carData['images'] ?? ['https://via.placeholder.com/600x400']),
            'description' => $carData['description'] ?? 'Xe được bảo dưỡng tốt, sạch sẽ, phù hợp cho mọi chuyến đi.',
            'features' => json_encode($carData['features'] ?? ['GPS', 'Bluetooth', 'Camera lùi']),
            'is_available' => true,
            'is_verified' => true,
        ]);
    }

    private function mapLocation($location): string
    {
        $locationMap = [
            'Hà Nội' => 'Hà Nội',
            'TP.HCM' => 'TP.HCM',
            'Đà Nẵng' => 'Đà Nẵng',
            'Hải Phòng' => 'Hải Phòng',
            'Cần Thơ' => 'Cần Thơ',
        ];

        return $locationMap[$location] ?? 'TP.HCM';
    }

    private function mapTransmission($transmission): string
    {
        $transmission = strtolower($transmission);
        if (str_contains($transmission, 'tự động') || str_contains($transmission, 'automatic')) {
            return 'Tự động';
        }
        return 'Số sàn';
    }

    private function mapFuel($fuel): string
    {
        $fuel = strtolower($fuel);
        if (str_contains($fuel, 'điện')) {
            return 'Điện';
        } elseif (str_contains($fuel, 'dầu')) {
            return 'Dầu';
        }
        return 'Xăng';
    }

    private function parsePrice($price): int
    {
        if (is_numeric($price)) {
            return (int) $price;
        }

        // Remove currency symbols and commas
        $price = preg_replace('/[^\d]/', '', $price);
        return (int) $price ?: 1000000;
    }

    private function parseTrip($trip): int
    {
        if (is_numeric($trip)) {
            return (int) $trip;
        }

        // Extract numbers from string
        preg_match('/\d+/', $trip, $matches);
        return isset($matches[0]) ? (int) $matches[0] : 0;
    }

    private function parseSeat($seat): int
    {
        if (is_numeric($seat)) {
            return (int) $seat;
        }

        // Extract numbers from string
        preg_match('/\d+/', $seat, $matches);
        return isset($matches[0]) ? (int) $matches[0] : 5;
    }

    private function findOwnerId($carData, $users, $userCarMapping, &$userIndex): int
    {
        // Try to find owner from mapping
        $miotoCarId = $carData['mioto_car_id'] ?? null;
        if ($miotoCarId && isset($userCarMapping[$miotoCarId])) {
            $miotoUserId = $userCarMapping[$miotoCarId];
            $user = $users->firstWhere('email', 'like', "%{$miotoUserId}%");
            if ($user) {
                return $user->id;
            }
        }

        // Fallback to round-robin assignment
        $user = $users[$userIndex % $users->count()];
        $userIndex++;
        return $user->id;
    }

    private function generateFakeCarData($index): array
    {
        $brands = ['Toyota', 'Honda', 'Hyundai', 'Kia', 'Ford', 'Mazda', 'Mitsubishi', 'Nissan'];
        $models = ['Camry', 'Civic', 'Accent', 'Morning', 'Ranger', 'CX-5', 'X-Trail', 'Altis'];
        $locations = ['Hà Nội', 'TP.HCM', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ'];
        $transmissions = ['Tự động', 'Số sàn'];
        $fuels = ['Xăng', 'Dầu', 'Điện'];

        return [
            'model' => $models[$index % count($models)] . ' ' . (2020 + ($index % 4)),
            'brand' => $brands[$index % count($brands)],
            'year' => 2020 + ($index % 4),
            'price' => 800000 + ($index * 50000),
            'location' => $locations[$index % count($locations)],
            'transmission' => $transmissions[$index % count($transmissions)],
            'fuel' => $fuels[$index % count($fuels)],
            'trip' => $index * 1000,
            'seat' => 5 + ($index % 3),
            'images' => ['https://via.placeholder.com/600x400'],
            'description' => 'Xe mới, bảo dưỡng định kỳ, sạch sẽ, tiện nghi đầy đủ.',
            'features' => ['GPS', 'Bluetooth', 'Camera lùi', 'Cruise control'],
        ];
    }
}
