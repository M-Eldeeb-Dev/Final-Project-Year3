<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::active()
            ->featured()
            ->inStock()
            ->with('category')
            ->take(4)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->get();

        return view('home', compact('featured', 'categories'));
    }
}
