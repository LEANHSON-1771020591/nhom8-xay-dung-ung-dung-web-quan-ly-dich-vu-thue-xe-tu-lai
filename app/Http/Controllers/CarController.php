<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    public function show($slug)
    {
        $car = Car::where('slug', $slug)->first();
        if (!$car) {
            return redirect('/')->with('error', 'Xe không tồn tại');
        }
        return view('car.show', compact('car'));
    }
}
