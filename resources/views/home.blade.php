@extends('layouts.app')

@section('title', 'Browse Events - VoteAfrika')
@section('meta_description', 'Discover and vote in exciting events on VoteAfrika. Support your favorite nominees and make your voice heard.')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <!-- Hero Header -->
    <section class="relative overflow-hidden bg-white border-b border-gray-100">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-[0.02]">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="events-grid" width="20" height="20" patternUnits="userSpaceOnUse">
                        <path d="M 20 0 L 0 0 0 20" fill="none" stroke="currentColor" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#events-grid)"/>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-gray-900 mb-4">
                    Discover <span class="text-gradient-gold">Events</span>
                </h1>
                <p class="text-gray-600 text-lg mb-8">
                    Browse exciting voting events and support your favorite nominees
                </p>

                <!-- Search Bar -->
                <div class="max-w-xl mx-auto">
                    <div class="relative">
                        <input
                            type="text"
                            id="search"
                            placeholder="Search events..."
                            class="w-full pl-5 pr-12 py-4 text-base bg-white rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gold/20 focus:border-gold transition-all shadow-sm"
                        />
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Grid Section -->
    <section class="py-10 lg:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($events->count() > 0)
                <!-- Results Count -->
                <div class="flex items-center justify-between mb-6">
                    <p class="text-gray-600 text-sm">
                        Showing <span class="font-semibold text-gray-900">{{ $events->count() }}</span> events
                    </p>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 text-sm">Sort by:</span>
                        <select class="text-sm font-medium text-gray-700 bg-transparent border-none focus:ring-0 cursor-pointer">
                            <option>Latest</option>
                            <option>Popular</option>
                            <option>Ending Soon</option>
                        </select>
                    </div>
                </div>

                <!-- Events Grid -->
                <div id="events-grid" class="grid grid-cols-2 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
                    @foreach($events as $event)
                        @php
                            $isExpired = $event->status === 'completed';
                        @endphp
                        
                        <div class="searchable-item group {{ $isExpired ? 'expired-event' : '' }}">
                            @if($isExpired)
                                {{-- Expired Event - Not Clickable --}}
                                <div class="block bg-white rounded-xl border border-gray-100 overflow-hidden opacity-60 cursor-not-allowed relative">
                                    {{-- Expired Overlay --}}
                                    <div class="absolute inset-0 bg-gray-900/10 z-10 pointer-events-none"></div>
                                    
                                    <!-- Event Image -->
                                    <div class="relative aspect-[4/3] bg-gradient-to-br from-brown to-brown-dark overflow-hidden grayscale">
                                        @if($event->banner_image)
                                            <img
                                                src="{{ asset('storage/' . $event->banner_image) }}"
                                                alt="{{ $event->name }}"
                                                class="w-full h-full object-cover"
                                            >
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <div class="text-center">
                                                    <div class="w-16 h-16 bg-gradient-to-br from-gold to-gold-dark rounded-xl flex items-center justify-center mx-auto mb-2 shadow-lg transform rotate-3">
                                                        <svg class="w-8 h-8 text-brown-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Expired Badge -->
                                        <div class="absolute top-3 left-3 z-20">
                                            <span class="inline-flex items-center gap-1.5 bg-red-600 text-white text-xs font-semibold px-2.5 py-1 rounded-full shadow-lg">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Expired
                                            </span>
                                        </div>

                                        <!-- Vote Price Badge -->
                                        <div class="absolute bottom-3 right-3">
                                            <span class="inline-flex items-center bg-white/95 backdrop-blur-sm text-gray-500 text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm line-through">
                                                ₦{{ number_format($event->vote_price) }}/vote
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Event Content -->
                                    <div class="p-4">
                                        <h3 class="text-sm font-semibold text-gray-500 leading-snug line-clamp-2 mb-2">
                                            {{ $event->name }}
                                        </h3>

                                        <p class="text-xs text-gray-400 mb-3">
                                            Ended {{ $event->end_date->format('M d, Y') }}
                                        </p>

                                        <!-- Disabled Button -->
                                        <button disabled class="w-full py-2 bg-gray-100 text-gray-400 text-xs font-semibold rounded-lg cursor-not-allowed">
                                            Voting Closed
                                        </button>
                                    </div>
                                </div>
                            @else
                                {{-- Active/Draft Event - Clickable --}}
                                <a href="{{ route('events.show', $event->slug) }}" class="block bg-white rounded-xl border border-gray-100 overflow-hidden hover:border-gold/30 hover:shadow-lg transition-all duration-300">
                                    <!-- Event Image -->
                                    <div class="relative aspect-[4/3] bg-gradient-to-br from-brown to-brown-dark overflow-hidden">
                                        @if($event->banner_image)
                                            <img
                                                src="{{ asset('storage/' . $event->banner_image) }}"
                                                alt="{{ $event->name }}"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                            >
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <div class="text-center">
                                                    <div class="w-16 h-16 bg-gradient-to-br from-gold to-gold-dark rounded-xl flex items-center justify-center mx-auto mb-2 shadow-lg transform rotate-3 group-hover:rotate-6 transition-transform">
                                                        <svg class="w-8 h-8 text-brown-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Status Badge -->
                                        @if($event->status === 'active')
                                            <div class="absolute top-3 left-3">
                                                <span class="inline-flex items-center gap-1.5 bg-green-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full shadow-lg">
                                                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                                    Live
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Vote Price Badge -->
                                        <div class="absolute bottom-3 right-3">
                                            <span class="inline-flex items-center bg-white/95 backdrop-blur-sm text-gray-900 text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm">
                                                ₦{{ number_format($event->vote_price) }}/vote
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Event Content -->
                                    <div class="p-4">
                                        <h3 class="text-sm font-semibold text-gray-900 leading-snug line-clamp-2 group-hover:text-gold-dark transition-colors mb-2">
                                            {{ $event->name }}
                                        </h3>

                                        <p class="text-xs text-gray-500 mb-3">
                                            {{ $event->start_date->format('M d, Y') }} • {{ $event->start_date->format('g:i A') }}
                                        </p>

                                        <!-- CTA Button -->
                                        <button class="w-full py-2 bg-gray-50 group-hover:bg-gradient-to-r group-hover:from-gold group-hover:to-gold-dark text-gray-700 group-hover:text-brown-dark text-xs font-semibold rounded-lg transition-all duration-300">
                                            View Event
                                        </button>
                                    </div>
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- No Results Message (Hidden by default) -->
                <div id="no-results-message" class="hidden text-center py-16">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No events found</h3>
                    <p class="text-gray-500 text-sm">Try a different search term</p>
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $events->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-display font-bold text-gray-900 mb-3">No Events Available</h3>
                    <p class="text-gray-500 max-w-md mx-auto mb-8">There are no events at the moment. Check back soon for exciting voting opportunities!</p>
                    <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-gold to-gold-dark text-brown-dark font-semibold rounded-xl hover:shadow-lg transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Home
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    @if($events->count() > 0)
        <section class="py-12 lg:py-16 bg-gradient-to-br from-brown to-brown-dark">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-2xl sm:text-3xl font-display font-bold text-white mb-4">
                    Want to Host Your Own Event?
                </h2>
                <p class="text-white/70 mb-8 max-w-2xl mx-auto">
                    Create engaging voting events with VoteAfrika's powerful platform. Easy setup, real-time results, and secure payments.
                </p>
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-brown-dark rounded-xl font-semibold hover:bg-gold transition-all">
                    Get Started Free
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </section>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const eventsGrid = document.getElementById('events-grid');
        const noResultsMessage = document.getElementById('no-results-message');

        searchInput?.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const items = document.querySelectorAll('.searchable-item');
            let visibleCount = 0;

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                const shouldShow = text.includes(query);
                item.style.display = shouldShow ? '' : 'none';
                if (shouldShow) visibleCount++;
            });

            // Show/hide no results message
            if (visibleCount === 0 && query !== '') {
                noResultsMessage?.classList.remove('hidden');
                eventsGrid?.classList.add('hidden');
            } else {
                noResultsMessage?.classList.add('hidden');
                eventsGrid?.classList.remove('hidden');
            }
        });
    });
</script>
@endpush
@endsection