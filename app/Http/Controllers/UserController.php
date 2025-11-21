<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Car;
use App\Models\Booking;

class UserController extends Controller
{
    public function show($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $cars = Car::where('owner_id', $user->id)->get();
        $trips = Booking::whereHas('car', function($q) use ($user) {
            $q->where('owner_id', $user->id);
        })->where('status','confirmed')->count();
        return view('users.show', compact('user','cars','trips'));
    }
}