@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.events.show', $category->event) }}" class="text-indigo-600 hover:text-indigo-700">
        ← Back to {{ $category->event->name }}
    </a>
</div>

<div class="bg-white rounded-lg shadow p-8 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Category</h1>

    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                <input type="text" name="name" required value="{{ old('name', $category->name) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="e.g., Best Male Artist">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                          placeholder="Brief description of this category">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                <input type="number" name="order" min="0" value="{{ old('order', $category->order) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                @error('order')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Lower numbers appear first</p>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.events.show', $category->event) }}"
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Update Category
                </button>
            </div>
        </div>
    </form>

    <!-- Delete Category -->
    <div class="mt-8 pt-8 border-t border-gray-200">
        <h3 class="text-lg font-semibold text-red-600 mb-4">Danger Zone</h3>
        <p class="text-sm text-gray-600 mb-4">
            Deleting this category will also delete all contestants and their votes. This action cannot be undone.
        </p>
        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
              onsubmit="return confirm('Are you sure you want to delete this category? This will also delete all contestants and votes!')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                Delete Category
            </button>
        </form>
    </div>
</div>
@endsection