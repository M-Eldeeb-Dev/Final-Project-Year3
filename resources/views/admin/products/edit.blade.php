@extends('layouts.admin')
@section('page-title', 'Edit Product')

@section('content')
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- LEFT COLUMN: Content -->
        <div class="lg:w-[60%] space-y-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-4 border-b pb-2">Basic Info</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Product Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SKU <span class="text-red-500">*</span></label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                        <textarea name="short_description" rows="3" class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Description <span class="text-red-500">*</span></label>
                        <textarea name="description" rows="6" required class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6" x-data="{ imgUrl: {{ Js::from(old('image_url', $product->image_url)) }} }">
                <h3 class="font-semibold text-gray-700 mb-4 border-b pb-2">Media</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload New Product Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold bg-white" @change="if($event.target.files.length) imgUrl = URL.createObjectURL($event.target.files[0])">
                    </div>
                </div>

                <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center min-h-[200px] bg-gray-50">
                    <template x-if="imgUrl">
                        <img :src="imgUrl" class="max-h-[300px] object-contain mx-auto shadow-sm" x-on:error="$event.target.src=''">
                    </template>
                    <template x-if="!imgUrl">
                        <span class="text-gray-400 text-sm">Image Preview</span>
                    </template>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Options & Pricing -->
        <div class="lg:w-[40%] space-y-6">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-[88px]">
                <h3 class="font-semibold text-gray-700 mb-4 border-b pb-2">Status & Organization</h3>

                <div class="space-y-5 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                        <select name="category_id" required class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center space-x-3 bg-gray-50 p-3 rounded mt-3">
                        <input type="checkbox" name="is_featured" value="1" id="is_featured" class="w-4 h-4 text-gold rounded border-gray-300 focus:ring-gold" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        <label for="is_featured" class="text-sm font-medium text-gray-700">Display as Featured Product</label>
                    </div>

                    <div class="flex items-center space-x-3 bg-gray-50 p-3 rounded mt-3">
                        <input type="checkbox" name="is_active" value="1" id="is_active" class="w-4 h-4 text-gold rounded border-gray-300 focus:ring-gold" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="text-sm font-medium text-gray-700">Active (Visible in Store)</label>
                    </div>
                </div>

                <h3 class="font-semibold text-gray-700 mb-4 border-b pb-2">Pricing & Inventory</h3>

                <div class="space-y-4 mb-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price ($) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sale Price ($)</label>
                            <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Units in Stock <span class="text-red-500">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold">
                    </div>
                </div>

                <h3 class="font-semibold text-gray-700 mb-4 border-b pb-2">Variations</h3>

                <div class="space-y-4 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sizes (comma separated)</label>
                        <input type="text" name="size_options" value="{{ old('size_options', $product->size_options) }}" placeholder="e.g. XS,S,M,L,XL" class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Colors (comma separated)</label>
                        <input type="text" name="color_options" value="{{ old('color_options', $product->color_options) }}" placeholder="e.g. Black,White,Gold" class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold">
                    </div>
                </div>

                <div class="space-y-3">
                    <button type="submit" class="w-full bg-gold hover:bg-[#b09038] text-white py-3 rounded font-bold uppercase tracking-wider transition-colors shadow-sm">
                        Update Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="block w-full text-center py-3 text-sm text-gray-600 hover:text-gray-900 border rounded hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
