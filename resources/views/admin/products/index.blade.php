@extends('layouts.admin')
@section('page-title', 'Products')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-100">
    <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-lg">
        <div class="flex space-x-2">
            <form method="GET" class="flex space-x-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="border-gray-300 rounded focus:border-[#C9A84C] focus:ring-[#C9A84C] text-sm px-3 py-1.5 border">

                <select name="category" class="border-gray-300 rounded focus:border-[#C9A84C] text-sm px-3 py-1.5 border">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>

                <select name="status" class="border-gray-300 rounded focus:border-[#C9A84C] text-sm px-3 py-1.5 border">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="low" {{ request('status') === 'low' ? 'selected' : '' }}>Low Stock</option>
                    <option value="trashed" {{ request('status') === 'trashed' ? 'selected' : '' }}>Trashed</option>
                </select>

                <button type="submit" class="bg-gray-800 text-white px-3 py-1.5 rounded text-sm hover:bg-black transition-colors">Filter</button>
            </form>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-gold hover:bg-[#b09038] text-white px-4 py-2 rounded text-sm font-semibold transition-colors">
            + Add Product
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 bg-gray-50 uppercase border-b">
                <tr>
                    <th class="px-4 py-3">Image</th>
                    <th class="px-4 py-3">Name / SKU</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Price</th>
                    <th class="px-4 py-3">Stock</th>
                    <th class="px-4 py-3 text-center">Featured</th>
                    <th class="px-4 py-3 text-center">Active</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50 {{ $product->trashed() ? 'opacity-50' : '' }}">
                        <td class="px-4 py-3">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded shadow-sm border">
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900">{{ $product->name }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">SKU: {{ $product->sku }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">
                                {{ $product->category?->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($product->sale_price)
                                <div class="font-semibold text-gray-900">${{ $product->sale_price }}</div>
                                <div class="text-xs text-gray-400 line-through">${{ $product->price }}</div>
                            @else
                                <div class="font-semibold text-gray-900">${{ $product->price }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="font-semibold {{ $product->stock <= 5 ? 'text-red-500' : 'text-green-600' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if(!$product->trashed())
                            <form action="{{ route('admin.products.featured', $product) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-10 h-5 {{ $product->is_featured ? 'bg-gold' : 'bg-gray-300' }} rounded-full relative transition-colors focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-gold">
                                    <span class="absolute top-0.5 {{ $product->is_featured ? 'left-5.5 right-0.5' : 'left-0.5' }} bg-white w-4 h-4 rounded-full transition-all shadow-sm"></span>
                                </button>
                            </form>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if(!$product->trashed())
                            <form action="{{ route('admin.products.toggle', $product) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-10 h-5 {{ $product->is_active ? 'bg-green-500' : 'bg-gray-300' }} rounded-full relative transition-colors focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-green-500">
                                    <span class="absolute top-0.5 {{ $product->is_active ? 'left-5.5 right-0.5' : 'left-0.5' }} bg-white w-4 h-4 rounded-full transition-all shadow-sm"></span>
                                </button>
                            </form>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if(!$product->trashed())
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 text-xs font-semibold uppercase tracking-wider">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to move this product to trash?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-xs font-semibold uppercase tracking-wider">Trash</button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-red-500 font-bold uppercase tracking-wider border border-red-500 px-2 py-0.5 rounded">Trashed</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">No products found fitting this criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
