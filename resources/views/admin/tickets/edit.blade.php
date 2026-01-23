@extends('layouts.admin')

@section('title', 'Edit Ticket')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.events.show', $ticket->event) }}" class="text-indigo-600 hover:text-indigo-700">
        ← Back to {{ $ticket->event->name }}
    </a>
</div>

<div class="bg-white rounded-lg shadow p-8 max-w-2xl">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Ticket</h1>

    <form method="POST" action="{{ route('admin.tickets.update', $ticket) }}">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ticket Name *</label>
                <input type="text" name="name" required value="{{ old('name', $ticket->name) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="e.g., VIP Ticket">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $ticket->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (₦) *</label>
                    <input type="number" name="price" step="0.01" min="0" required value="{{ old('price', $ticket->price) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Quantity *</label>
                    <input type="number" name="quantity" min="1" required value="{{ old('quantity', $ticket->quantity) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    @error('quantity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">Already sold: {{ $ticket->sold }}</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ticket Type *</label>
                <select name="type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="regular" {{ old('type', $ticket->type) === 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="vip" {{ old('type', $ticket->type) === 'vip' ? 'selected' : '' }}>VIP</option>
                    <option value="vvip" {{ old('type', $ticket->type) === 'vvip' ? 'selected' : '' }}>VVIP</option>
                    <option value="early_bird" {{ old('type', $ticket->type) === 'early_bird' ? 'selected' : '' }}>Early Bird</option>
                </select>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stats Display -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Sales Statistics</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Sold</p>
                        <p class="text-2xl font-bold text-green-600">{{ $ticket->sold }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Available</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $ticket->available_quantity }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Revenue</p>
                        <p class="text-2xl font-bold text-indigo-600">₦{{ number_format($ticket->sold * $ticket->price) }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.events.show', $ticket->event) }}"
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Update Ticket
                </button>
            </div>
        </div>
    </form>

    <!-- Delete Ticket -->
    <div class="mt-8 pt-8 border-t border-gray-200">
        <h3 class="text-lg font-semibold text-red-600 mb-4">Danger Zone</h3>
        <p class="text-sm text-gray-600 mb-4">
            Deleting this ticket will prevent future sales. Already sold tickets will remain valid.
        </p>
        <form method="POST" action="{{ route('admin.tickets.destroy', $ticket) }}" 
              onsubmit="return confirm('Are you sure you want to delete this ticket type?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                Delete Ticket Type
            </button>
        </form>
    </div>
</div>
@endsection