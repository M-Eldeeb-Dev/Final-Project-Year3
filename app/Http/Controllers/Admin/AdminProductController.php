<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\Admin\AdminProductRequest;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::withTrashed()
            ->with('category')
            ->when(request('search'), fn($q) => $q->where('name', 'like', '%'.request('search').'%'))
            ->when(request('category'), fn($q) => $q->where('category_id', request('category')))
            ->when(request('status') === 'active',   fn($q) => $q->where('is_active', true))
            ->when(request('status') === 'inactive', fn($q) => $q->where('is_active', false))
            ->when(request('status') === 'trashed',  fn($q) => $q->onlyTrashed())
            ->when(request('stock') === 'low',       fn($q) => $q->where('stock', '<=', 5))
            ->latest()->paginate(15)->withQueryString();

        $categories = Category::where('is_active', true)->get();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(AdminProductRequest $request)
    {
        $data = $request->validated();

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = Storage::url($path);
        }

        Product::create($data);

        return redirect()->route('admin.products.index')
               ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(AdminProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = Storage::url($path);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
               ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product moved to trash.');
    }

    public function toggle(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('success', 'Product visibility updated.');
    }

    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);
        return back()->with('success', 'Featured status updated.');
    }
}
