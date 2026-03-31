@extends('layouts.admin')
@section('page-title', 'Categories')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    {{-- HEADER --}}
    <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center bg-white gap-4">
        <div>
            <h3 class="font-bold text-gray-900 tracking-tight">All Categories</h3>
            <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Manage store collections</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="w-full sm:w-auto text-center bg-gold hover:bg-[#b09038] text-white px-6 py-2.5 rounded-lg text-xs font-bold uppercase tracking-widest transition-all shadow-sm shadow-gold/20">
            + Add Category
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 bg-gray-50 uppercase border-b">
                <tr>
                    <th class="px-4 py-3">Image</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3 text-center">Products</th>
                    <th class="px-4 py-3 text-center">Active</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            @if($category->image_url)
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-12 h-12 object-cover rounded shadow-sm border">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center text-gray-400 border text-xs">No Img</div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900">{{ $category->name }}</div>
                            @if($category->description)
                                <div class="text-xs text-gray-500 mt-0.5 truncate w-48">{{ Str::limit($category->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-500">{{ $category->slug }}</td>
                        <td class="px-4 py-3 text-center font-semibold">
                            {{ $category->products_count }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('admin.categories.toggle', $category) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="w-10 h-5 {{ $category->is_active ? 'bg-green-500' : 'bg-gray-300' }} rounded-full relative transition-colors focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-green-500">
                                    <span class="absolute top-0.5 {{ $category->is_active ? 'left-5.5 right-0.5' : 'left-0.5' }} bg-white w-4 h-4 rounded-full transition-all shadow-sm"></span>
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-900 text-xs font-semibold uppercase tracking-wider">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-xs font-semibold uppercase tracking-wider">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
