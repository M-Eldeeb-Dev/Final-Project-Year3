<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::active()->with('category');


        if ($categorySlug = request('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }


        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }


        match (request('sort')) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'newest'     => $query->latest(),
            default      => $query->orderBy('is_featured', 'desc')->latest(),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);

        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'related'));
    }
}
