<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OwnerController extends Controller
{
    public function create()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập để đăng ký xe');
        }
        return view('owner.index');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập để đăng ký xe');
        }
        
        $userId = Auth::id();
        
        $validated = $request->validate([
            'model' => 'required|string|min:2',
            'address' => 'required|string|min:2',
            'location' => 'required|string',
            'price' => 'required|integer|min:1',
            'seat' => 'required|integer|min:4',
            'transmission' => 'required|in:AT,MT',
            'fuel' => 'required|in:Xăng,Dầu,Điện',
            'images' => 'required|array|size:4',
            'images.*' => 'file|mimes:jpg,jpeg,png,webp|max:5120',
            'desc' => 'required|string|min:10',
        ]);
        
        $slug = Str::slug($validated['model']) . '-' . Str::random(6);
        
        $paths = [];
        foreach ($request->file('images') as $file) {
            $paths[] = $file->store('cars', 'public');
        }
        
        $car = Car::create([
            'model' => $validated['model'],
            'address' => $validated['address'],
            'location' => $validated['location'],
            'price' => (string)$validated['price'],
            'images' => $paths,
            'desc' => $validated['desc'],
            'trip' => 0,
            'transmission' => $validated['transmission'],
            'seat' => (int)$validated['seat'],
            'fuel' => $validated['fuel'],
            'consumed' => '—',
            'owner_id' => $userId,
            'slug' => $slug,
        ]);
        
        return redirect('/car/' . $car->slug)->with('success', 'Đã đăng ký xe thành công');
    }

    public function edit(Car $car)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập');
        }
        
        $userId = Auth::id();
        
        if ($car->owner_id !== $userId) {
            return redirect('/my-trips')->with('error', 'Bạn không thể sửa xe của người khác');
        }
        
        return view('owner.index', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập');
        }
        
        $userId = Auth::id();
        
        if ($car->owner_id !== $userId) {
            return redirect('/my-trips')->with('error', 'Bạn không thể sửa xe của người khác');
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
        
        if ($paths !== null) {
            $car->images = $paths;
        }
        
        $car->desc = $validated['desc'];
        $car->transmission = $validated['transmission'];
        $car->seat = (int)$validated['seat'];
        $car->fuel = $validated['fuel'];
        $car->save();
        
        return redirect('/car/' . $car->slug)->with('success', 'Đã cập nhật xe thành công');
    }

    public function destroy(Car $car)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập');
        }
        
        $userId = Auth::id();
        
        if ($car->owner_id !== $userId) {
            return redirect('/my-trips')->with('error', 'Bạn không thể xóa xe của người khác');
        }
        
        $car->delete();
        return redirect('/my-trips')->with('success', 'Đã xóa xe thành công');
    }
}
