<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Car;
use App\Models\User;

class CarMiotoSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/mioto_cars.json');
        if (!File::exists($path)) {
            return;
        }
        $json = File::get($path);
        $items = collect(json_decode($json, true));
        $seenIds = [];

        // Optional mapping file: {id, user_id, car_id, mioto_user_id, mioto_car_id}
        $map = collect();
        $mapPath = database_path('data/mioto_user_car.json');
        if (File::exists($mapPath)) {
            $map = collect(json_decode(File::get($mapPath), true));
        }

        // Load users reference from mioto_users.json to resolve names
        $usersRef = collect();
        $usersPath = database_path('data/mioto_users.json');
        if (File::exists($usersPath)) {
            $usersRef = collect(json_decode(File::get($usersPath), true));
        }

        // Ensure owners exist; if not, import from usersRef
        if (User::where('role','owner')->count() === 0 && $usersRef->isNotEmpty()) {
            $usersRef->each(function($u){
                $name = $u['username'] ?? ($u['name'] ?? 'Người dùng');
                $avatar = $u['user_img'] ?? ($u['avatar'] ?? 'https://via.placeholder.com/80');
                $slug = \Illuminate\Support\Str::slug($name);
                $identifier = $u['mioto_user_id'] ?? ($u['id'] ?? \Illuminate\Support\Str::random(6));
                $email = 'mioto_'.$slug.'_'.$identifier.'@import.local';
                if (!User::where('email',$email)->exists()) {
                    User::create([
                        'name' => $name,
                        'email' => $email,
                        'password' => bcrypt('secret123'),
                        'avatar' => $avatar,
                        'slug' => $slug,
                        'role' => 'owner',
                        'is_locked' => false,
                    ]);
                }
            });
        }
        $owners = User::where('role', 'owner')->get(['id','email','slug','name']);
        $ownerCount = $owners->count();
        $i = 0;

        $genericOwner = User::firstOrCreate(
            ['email' => 'unknown_owner@import.local'],
            [
                'name' => 'Unknown Owner',
                'password' => bcrypt('secret123'),
                'avatar' => 'https://via.placeholder.com/80',
                'slug' => 'unknown-owner',
                'role' => 'owner',
                'is_locked' => false,
            ]
        );

        $mapCity = function ($loc) {
            $m = [
                'TP.HCM' => 'ho-chi-minh',
                'TP.Hồ Chí Minh' => 'ho-chi-minh',
                'Ha Noi' => 'ha-noi',
                'Hà Nội' => 'ha-noi',
                'Da Nang' => 'da-nang',
                'Đà Nẵng' => 'da-nang',
                'Thanh Hoa' => 'thanh-hoa',
                'Thanh Hóa' => 'thanh-hoa',
            ];
            return $m[$loc] ?? Str::slug($loc);
        };

        $mapTransmission = function ($t) {
            if (Str::lower($t) === 'số tự động' || Str::lower($t) === 'tự động') return 'AT';
            if (Str::lower($t) === 'số sàn') return 'MT';
            return 'AT';
        };

        $mapFuel = function ($f) {
            $f = Str::lower($f);
            if ($f === 'xăng') return 'Xăng';
            if ($f === 'điện') return 'Điện';
            if ($f === 'diesel' || $f === 'dầu') return 'Dầu';
            return 'Xăng';
        };

        $parseSeat = function ($s) {
            return (int) preg_replace('/[^0-9]/', '', (string) $s);
        };

        $parseTrip = function ($t) {
            return (int) preg_replace('/[^0-9]/', '', (string) $t);
        };

        $parsePrice = function ($p) {
            $n = preg_replace('/[^0-9]/', '', (string) $p);
            return (string) ($n ?: '0');
        };

        $items->each(function ($car) use (&$i, $owners, $ownerCount, $mapCity, $mapTransmission, $mapFuel, $parseSeat, $parseTrip, $parsePrice, $map, $usersRef, &$seenIds) {
            $ownerId = null;
            $srcId = $car['mioto_car_id'] ?? ($car['id'] ?? null);
            if ($srcId !== null) {
                if (isset($seenIds[$srcId])) {
                    return;
                }
            }
            // Resolve owner from mapping file (car.id -> user_id) and usersRef
            $mapRow = $map->first(function($m) use ($car){
                return ($m['car_id'] ?? null) === ($car['id'] ?? null);
            });
            if ($mapRow) {
                $userIdInJson = $mapRow['user_id'] ?? null;
                $userRow = $usersRef->first(function($u) use ($userIdInJson){
                    return ($u['id'] ?? null) === $userIdInJson;
                });
                $owner = null;
                if ($userRow) {
                    $owner = $owners->firstWhere('name', $userRow['username'] ?? $userRow['name'] ?? null);
                    if (!$owner) {
                        $owner = $owners->firstWhere('slug', \Illuminate\Support\Str::slug($userRow['username'] ?? $userRow['name'] ?? ''));
                    }
                }
                $ownerId = $owner?->id;
            }
            // Fallback: use car.mioto_user_id matching email pattern created by MiotoUsersSeeder
            if (!$ownerId && !empty($car['mioto_user_id'])) {
                $slug = \Illuminate\Support\Str::slug($car['mioto_user_id']);
                $owner = $owners->first(function($o) use ($car){
                    return str_contains($o->email, (string)($car['mioto_user_id']));
                });
                $ownerId = $owner?->id;
            }
            if (!$ownerId) {
                // Try to create/find owner from car.mioto_user_id
                if (!empty($car['mioto_user_id'])) {
                    $identifier = (string) $car['mioto_user_id'];
                    $email = 'mioto_owner_'.$identifier.'@import.local';
                    $owner = User::firstOrCreate(
                        ['email' => $email],
                        [
                            'name' => 'Owner '.$identifier,
                            'password' => bcrypt('secret123'),
                            'avatar' => 'https://via.placeholder.com/80',
                            'slug' => \Illuminate\Support\Str::slug('Owner '.$identifier),
                            'role' => 'owner',
                            'is_locked' => false,
                        ]
                    );
                    $ownerId = $owner->id;
                } else {
                    // Fallback to generic owner
                    $ownerId = $genericOwner->id;
                }
            }
            $i++;
            $slug = Str::slug($car['model']).'-'.Str::random(6);
            Car::create([
                'model' => $car['model'],
                'address' => $car['address'],
                'location' => $mapCity($car['location']),
                'price' => $parsePrice($car['price']),
                'images' => $car['images'],
                'desc' => $car['desc'] ?? '',
                'trip' => $parseTrip($car['trip'] ?? 0),
                'transmission' => $mapTransmission($car['transmission'] ?? ''),
                'seat' => $parseSeat($car['seat'] ?? 4),
                'fuel' => $mapFuel($car['fuel'] ?? 'Xăng'),
                'consumed' => $car['consumed'] ?? '—',
                'owner_id' => $ownerId,
                'slug' => $slug,
                'status' => 'approved',
            ]);
            if ($srcId !== null) $seenIds[$srcId] = true;
        });
    }
}

