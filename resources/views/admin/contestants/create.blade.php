{{-- resources/views/admin/contestants/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Add Contestant')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.events.show', $category->event) }}" class="text-indigo-600 hover:text-indigo-700">
        ← Back to {{ $category->event->name }}
    </a>
</div>

<div class="bg-white rounded-lg shadow p-8 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Add Contestant</h1>
    <p class="text-gray-600 mb-6">Category: {{ $category->name }}</p>

    <form method="POST" action="{{ route('admin.contestants.store', $category) }}" enctype="multipart/form-data">
        @csrf
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contestant Name *</label>
                <input type="text" name="name" required value="{{ old('name') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                <textarea name="bio" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Photo</label>
                <input type="file" name="photo" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Recommended size: 400x400px</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Video URL (Optional)</label>
                <input type="url" name="video_url" value="{{ old('video_url') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="https://youtube.com/watch?v=...">
                @error('video_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.events.show', $category->event) }}"
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Add Contestant
                </button>
            </div>
        </div>
    </form>
</div>
@endsection