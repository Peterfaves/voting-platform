{{-- resources/views/admin/tickets/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Create Ticket')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.events.show', $event) }}" class="text-indigo-600 hover:text-indigo-700">
        ← Back to {{ $event->name }}
    </a>
</div>

<div class="bg-white rounded-lg shadow p-8 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Create Ticket for {{ $event->name }}</h1>

    <form method="POST" action="{{ route('admin.tickets.store', $event) }}">
        @csrf
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ticket Name *</label>
                <input type="text" name="name" required value="{{ old('name') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="e.g., VIP Ticket">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (₦) *</label>
                    <input type="number" name="price" step="0.01" min="0" required value="{{ old('price') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                    <input type="number" name="quantity" min="1" required value="{{ old('quantity') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ticket Type *</label>
                <select name="type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="regular" {{ old('type') === 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="vip" {{ old('type') === 'vip' ? 'selected' : '' }}>VIP</option>
                    <option value="vvip" {{ old('type') === 'vvip' ? 'selected' : '' }}>VVIP</option>
                    <option value="early_bird" {{ old('type') === 'early_bird' ? 'selected' : '' }}>Early Bird</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.events.show', $event) }}"
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Create Ticket
                </button>
            </div>
        </div>
    </form>
</div>
@endsection