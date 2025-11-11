<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get('database/data/cars.json');
        $cars = collect(json_decode($json, true));
        $cars->each(function($car){
            Car::create([
                "model" => $car["model"],
                "address"=> $car["address"],
                "price"=> $car["price"],
                "images"=> $car["images"],
                "desc"=> $car["desc"],
                "trip"=> $car["trip"],
                "transmission"=> $car["transmission"],
                "seat"=> $car["seat"],
                "fuel"=> $car["fuel"],
                "consumed"=> $car["consumed"],
                "owner_id"=> $car["owner_id"],
                "slug"=> $car["slug"],
                "location"=> $car["location"],
            ]);
        });
    
    }
}
