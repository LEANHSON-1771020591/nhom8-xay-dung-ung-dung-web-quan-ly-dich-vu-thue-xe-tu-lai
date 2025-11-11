<?php

use Illuminate\Support\Facades\Route;
use App\Models\Car;

Route::get('/', function () {

    $cars = Car::take(8)->get();
    return view('index', compact('cars'));
});

Route::get("/filter/{slug}", function ($slug) {
    $cars = Car::where("location", $slug)->get();
    return view("category.index", compact(["slug", "cars"]));
});

Route::get("/car/{slug}", function ($slug) {
    $car = Car::where("slug", $slug)->first();
    return view("car.show", compact("car"));
});