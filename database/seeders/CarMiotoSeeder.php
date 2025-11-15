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
        $json = File::get($path);
        $items = collect(json_decode($json, true));

        $owners = User::where('role', 'owner')->pluck('id')->all();
        if (empty($owners)) {
            $owners = User::inRandomOrder()->take(100)->pluck('id')->all();
        }
        $ownerCount = count($owners);
        $i = 0;

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

        $items->each(function ($car) use (&$i, $owners, $ownerCount, $mapCity, $mapTransmission, $mapFuel, $parseSeat, $parseTrip, $parsePrice) {
            $ownerId = $owners[$i % max(1, $ownerCount)];
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
        });
    }
}

