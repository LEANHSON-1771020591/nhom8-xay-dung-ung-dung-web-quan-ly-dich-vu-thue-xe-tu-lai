<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminCarController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect(url('/admin/login'));
        }
        
        $location = request('location');
        $model = request('model');
        $transmission = request('transmission');
        $seat = request('seat');
        $fuel = request('fuel');
        $min = request('min_price');
        $max = request('max_price');
        
        $query = Car::query();
        
        if ($location) $query->where('location', $location);
        if ($model) $query->where('model','like','%'.$model.'%');
        if ($transmission) $query->where('transmission',$transmission);
        if ($seat) $query->where('seat',(int)$seat);
        if ($fuel) $query->where('fuel',$fuel);
        if ($min !== null && $min !== '') $query->whereRaw('CAST(price AS UNSIGNED) >= ?', [(int)$min]);
        if ($max !== null && $max !== '') $query->whereRaw('CAST(price AS UNSIGNED) <= ?', [(int)$max]);
        
        $cars = $query->orderBy('created_at','desc')->get();
        
        return view('admin.cars.index', compact('cars'));
    }

    public function edit(Car $car)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect(url('/admin/login'));
        }
        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect(url('/admin/login'));
        }
        
        $validated = $request->validate([
            'model' => 'required|string|min:2',
            'address' => 'required|string|min:2',
            'location' => 'required|string',
            'price' => 'required|integer|min:1',
            'seat' => 'required|integer|min:4',
            'transmission' => 'required|in:AT,MT',
            'fuel' => 'required|in:Xăng,Dầu,Điện',
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpg,jpeg,png,webp|max:5120',
            'desc' => 'required|string|min:10',
            'owner_id' => 'required|integer|exists:users,id',
        ]);
        
        $paths = null;
        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('cars', 'public');
            }
        }
        
        $car->model = $validated['model'];
        $car->address = $validated['address'];
        $car->location = $validated['location'];
        $car->price = (string)$validated['price'];
        if ($paths !== null) $car->images = $paths;
        $car->desc = $validated['desc'];
        $car->transmission = $validated['transmission'];
        $car->seat = (int)$validated['seat'];
        $car->fuel = $validated['fuel'];
        $car->owner_id = (int)$validated['owner_id'];
        $car->save();
        
        return redirect(url('/admin/cars'))->with('success','Đã cập nhật xe');
    }

    public function destroy(Car $car)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect(url('/admin/login'));
        }
        
        $car->delete();
        return redirect(url('/admin/cars'))->with('success','Đã xóa xe');
    }
}

