@extends('layouts.admin')

@section('title', 'Edit Contestant')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.events.show', $contestant->category->event) }}" class="text-indigo-600 hover:text-indigo-700">
        ← Back to {{ $contestant->category->event->name }}
    </a>
</div>

<div class="bg-white rounded-lg shadow p-8 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Edit Contestant</h1>
    <p class="text-gray-600 mb-6">Category: {{ $contestant->category->name }}</p>

    <form method="POST" action="{{ route('admin.contestants.update', $contestant) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contestant Name *</label>
                <input type="text" name="name" required value="{{ old('name', $contestant->name) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                <textarea name="bio" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">{{ old('bio', $contestant->bio) }}</textarea>
                @error('bio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Photo</label>
                @if($contestant->photo)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $contestant->photo) }}" 
                             class="h-32 w-32 object-cover rounded-lg">
                        <p class="text-sm text-gray-500 mt-1">Current photo</p>
                    </div>
                @endif
                <input type="file" name="photo" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Recommended size: 400x400px (Max: 2MB)</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Video URL (Optional)</label>
                <input type="url" name="video_url" value="{{ old('video_url', $contestant->video_url) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="https://youtube.com/watch?v=...">
                @error('video_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <select name="status" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="active" {{ old('status', $contestant->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="evicted" {{ old('status', $contestant->status) === 'evicted' ? 'selected' : '' }}>Evicted</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stats Display -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Current Statistics</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Total Votes</p>
                        <p class="text-2xl font-bold text-indigo-600">{{ number_format($contestant->total_votes) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Rank in Category</p>
                        <p class="text-2xl font-bold text-purple-600">#{{ $contestant->rank_in_category }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.events.show', $contestant->category->event) }}"
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Update Contestant
                </button>
            </div>
        </div>
    </form>

    <!-- Delete Contestant -->
    <div class="mt-8 pt-8 border-t border-gray-200">
        <h3 class="text-lg font-semibold text-red-600 mb-4">Danger Zone</h3>
        <p class="text-sm text-gray-600 mb-4">
            Deleting this contestant will also delete all their votes. This action cannot be undone.
        </p>
        <form method="POST" action="{{ route('admin.contestants.destroy', $contestant) }}" 
              onsubmit="return confirm('Are you sure you want to delete this contestant? This will also delete all their votes!')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                Delete Contestant
            </button>
        </form>
    </div>
</div>
@endsection