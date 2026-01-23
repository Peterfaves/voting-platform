@extends('layouts.admin')

@section('title', $event->name . ' - Event Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.events.index') }}" class="text-indigo-600 hover:text-indigo-700">
        ← Back to Events
    </a>
</div>

<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $event->name }}</h1>
                <p class="text-gray-600">{{ $event->description }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.events.edit', $event) }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Edit Event
                </a>
                <a href="{{ route('events.show', $event->slug) }}" target="_blank"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    View Public Page
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-6">
        <div class="text-center">
            <p class="text-sm text-gray-600 mb-1">Vote Price</p>
            <p class="text-2xl font-bold text-indigo-600">₦{{ number_format($event->vote_price) }}</p>
        </div>
        <div class="text-center">
            <p class="text-sm text-gray-600 mb-1">Total Votes</p>
            <p class="text-2xl font-bold text-purple-600">{{ number_format($totalVotes) }}</p>
        </div>
        <div class="text-center">
            <p class="text-sm text-gray-600 mb-1">Total Revenue</p>
            <p class="text-2xl font-bold text-green-600">₦{{ number_format($totalRevenue) }}</p>
        </div>
        <div class="text-center">
            <p class="text-sm text-gray-600 mb-1">Status</p>
            <p class="text-lg font-semibold 
                {{ $event->status === 'active' ? 'text-green-600' : 
                   ($event->status === 'completed' ? 'text-gray-600' : 'text-yellow-600') }}">
                {{ ucfirst($event->status) }}
            </p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900">Categories & Contestants</h2>
        <div class="space-x-2">
            <a href="{{ route('admin.categories.create', $event) }}" 
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                Add Category
            </a>
        </div>
    </div>

    @if($event->categories && $event->categories->count() > 0)
        @foreach($event->categories as $category)
        <div class="p-6 border-b border-gray-200 last:border-b-0">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $category->description }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.contestants.create', $category) }}" 
                       class="text-sm bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                        Add Contestant
                    </a>
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                        Edit Category
                    </a>
                </div>
            </div>

            @if($category->contestants && $category->contestants->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($category->contestants->sortByDesc('total_votes') as $index => $contestant)
                    <div class="border rounded-lg p-4 {{ $contestant->status === 'evicted' ? 'bg-red-50 border-red-300' : 'bg-gray-50' }}">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-2xl font-bold text-gray-400">#{{ $index + 1 }}</span>
                            @if($contestant->status === 'evicted')
                                <span class="text-xs bg-red-600 text-white px-2 py-1 rounded">Evicted</span>
                            @endif
                        </div>
                        @if($contestant->photo)
                            <img src="{{ asset('storage/' . $contestant->photo) }}" 
                                 alt="{{ $contestant->name }}"
                                 class="w-full h-32 object-cover rounded mb-2">
                        @endif
                        <h4 class="font-semibold text-gray-900 mb-1">{{ $contestant->name }}</h4>
                        <p class="text-2xl font-bold text-indigo-600 mb-2">{{ number_format($contestant->total_votes) }} votes</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.contestants.edit', $contestant) }}" 
                               class="text-xs text-blue-600 hover:text-blue-700">Edit</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No contestants yet. Add your first contestant!</p>
            @endif
        </div>
        @endforeach
    @else
        <div class="p-8 text-center text-gray-600">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No categories yet</h3>
            <p class="text-gray-600 mb-4">Get started by creating your first category</p>
            <a href="{{ route('admin.categories.create', $event) }}" 
               class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                Create Category
            </a>
        </div>
    @endif
</div>

<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-900">Event Tickets</h2>
        <a href="{{ route('admin.tickets.create', $event) }}" 
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            Add Ticket
        </a>
    </div>

    @if($event->tickets && $event->tickets->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sold / Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($event->tickets as $ticket)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $ticket->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-800">
                            {{ ucfirst($ticket->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">₦{{ number_format($ticket->price) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $ticket->sold }} / {{ $ticket->quantity }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <a href="{{ route('admin.tickets.edit', $ticket) }}" 
                           class="text-blue-600 hover:text-blue-700 mr-3">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-6 text-center text-gray-600">
        No tickets created yet.
    </div>
    @endif
</div>
@endsection