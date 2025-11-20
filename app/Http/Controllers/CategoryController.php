<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CategoryController extends Controller
{
    public function filter(Request $request, $slug)
    {
        $query = Car::where('location', $slug)->where('status', 'approved');
        $min = $request->input('min_price');
        $max = $request->input('max_price');
        $transmission = $request->input('transmission');
        $seat = $request->input('seat');
        $fuel = $request->input('fuel');
        $model = $request->input('model');
        if ($min !== null) {
            $query->whereRaw('CAST(price AS UNSIGNED) >= ?', [(int) $min]);
        }
        if ($max !== null) {
            $query->whereRaw('CAST(price AS UNSIGNED) <= ?', [(int) $max]);
        }
        if ($transmission !== null && $transmission !== '') {
            $query->where('transmission', $transmission);
        }
        if ($seat !== null && $seat !== '') {
            $query->where('seat', (int) $seat);
        }
        if ($fuel !== null && $fuel !== '') {
            $query->where('fuel', $fuel);
        }
        if ($model !== null && $model !== '') {
            $query->where('model', 'like', '%' . $model . '%');
        }
        $cars = $query->get();
        return view('category.index', compact(['slug', 'cars']));
    }
}
