<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        $cars = Car::where('status', 'approved')->take(8)->get();
        $blogs = Blog::orderByDesc('id')
            ->select(['id','title','content_text_preview','thumbnail','created_at'])
            ->take(3)->offset(67)
            ->get();
        return view('index', compact('cars','blogs'));
    }

    public function about()
    {
        return view('about.index');
    }
}
