<?php

namespace App\Http\Controllers;

use App\Models\Car;

class HomeController extends Controller
{
    public function index()
    {
        $cars = Car::where('status', 'approved')->take(8)->get();
        return view('index', compact('cars'));
    }

    public function about()
    {
        return view('about.index');
    }
}
