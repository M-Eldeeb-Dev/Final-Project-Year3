@extends('layouts.admin')
@section('page-title', 'Add Category')

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
        @csrf
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold">{{ old('description') }}</textarea>
            </div>

            <div x-data="{ imgUrl: '' }">
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Category Image</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border rounded focus:ring-gold focus:border-gold" @change="if($event.target.files.length) imgUrl = URL.createObjectURL($event.target.files[0])">
                <template x-if="imgUrl">
                    <div class="mt-3">
                        <img :src="imgUrl" class="h-32 object-contain border rounded p-1" x-on:error="$event.target.style.display='none'">
                    </div>
                </template>
            </div>

            <div class="flex items-center space-x-3 bg-gray-50 p-3 rounded mt-3">
                <input type="checkbox" name="is_active" value="1" id="is_active" class="w-4 h-4 text-gold rounded border-gray-300 focus:ring-gold" {{ old('is_active', true) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm font-medium text-gray-700">Active (Visible in Store)</label>
            </div>

            <div class="flex space-x-3 pt-4 border-t">
                <button type="submit" class="bg-gold hover:bg-[#b09038] text-white px-6 py-2 rounded font-semibold tracking-wide transition-colors">Save Category</button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 border text-gray-600 rounded hover:bg-gray-50 transition-colors">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
