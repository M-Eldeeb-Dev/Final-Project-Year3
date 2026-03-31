<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\Admin\AdminCategoryRequest;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(AdminCategoryRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $data['image_url'] = Storage::url($path);
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
               ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return redirect()->route('admin.categories.edit', $category);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(AdminCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $data['image_url'] = Storage::url($path);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
               ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete a category that has products. Deactivate it instead.');
        }
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    public function toggle(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        return back()->with('success', 'Category status updated.');
    }
}
