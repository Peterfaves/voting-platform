@extends('layouts.app')

@section('title', $category->name . ' - ' . $event->name . ' | VoteAfrika')
@section('meta_description', 'Vote for your favorite nominees in ' . $category->name . ' at ' . $event->name . ' on VoteAfrika.')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <!-- Hero Header -->
    <section class="relative overflow-hidden bg-white border-b border-gray-100">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-[0.02]">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="category-grid" width="20" height="20" patternUnits="userSpaceOnUse">
                        <path d="M 20 0 L 0 0 0 20" fill="none" stroke="currentColor" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#category-grid)"/>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-10">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center flex-wrap gap-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gold-dark transition-colors">Events</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li>
                        <a href="{{ route('events.show', $event->slug) }}" class="text-gray-500 hover:text-gold-dark transition-colors">{{ Str::limit($event->name, 30) }}</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li>
                        <span class="text-gray-900 font-medium">{{ $category->name }}</span>
                    </li>
                </ol>
            </nav>

            <!-- Category Header Card -->
            <div class="bg-gradient-to-br from-brown to-brown-dark rounded-2xl p-6 lg:p-8 text-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <span class="text-white/60 text-sm font-medium">{{ $event->name }}</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold mb-3">
                            {{ $category->name }}
                        </h1>
                        @if($category->description)
                            <p class="text-white/70 text-base lg:text-lg max-w-2xl">{{ $category->description }}</p>
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="flex gap-6 lg:gap-8">
                        <div class="text-center">
                            <div class="text-3xl lg:text-4xl font-display font-bold text-gold mb-1">
                                {{ $category->contestants->where('status', 'active')->count() }}
                            </div>
                            <div class="text-white/60 text-sm font-medium">Nominees</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl lg:text-4xl font-display font-bold text-gold mb-1">
                                ₦{{ number_format($event->vote_price) }}
                            </div>
                            <div class="text-white/60 text-sm font-medium">Per Vote</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nominees Grid Section -->
    <section class="py-10 lg:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($category->contestants->where('status', 'active')->count() > 0)
                <!-- Section Header -->
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-gold/10 to-gold-dark/10 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-display font-bold text-gray-900">Vote for Your Favorite</h2>
                            <p class="text-gray-500 text-sm">Select a nominee to cast your vote</p>
                        </div>
                    </div>
                </div>

                <!-- Nominees Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">
                    @foreach($category->contestants->where('status', 'active')->sortByDesc('total_votes') as $index => $contestant)
                        <a href="{{ route('voting.show', $contestant) }}" 
                           class="group relative bg-white rounded-2xl border border-gray-100 overflow-hidden hover:border-gold/40 hover:shadow-xl transition-all duration-300">
                            
                            <!-- Rank Badge (for top 3) -->
                            @if($index < 3)
                                <div class="absolute top-4 left-4 z-10">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold shadow-lg
                                        {{ $index === 0 ? 'bg-gradient-to-br from-yellow-400 to-yellow-500 text-yellow-900' : '' }}
                                        {{ $index === 1 ? 'bg-gradient-to-br from-gray-300 to-gray-400 text-gray-700' : '' }}
                                        {{ $index === 2 ? 'bg-gradient-to-br from-amber-600 to-amber-700 text-white' : '' }}">
                                        {{ $index + 1 }}
                                    </div>
                                </div>
                            @endif

                            <div class="p-5 lg:p-6">
                                <div class="flex items-start gap-4">
                                    <!-- Contestant Image -->
                                    <div class="flex-shrink-0">
                                        @if($contestant->photo)
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $contestant->photo) }}" 
                                                     alt="{{ $contestant->name }}"
                                                     class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-xl border-2 border-gray-100 group-hover:border-gold/50 transition-colors">
                                                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-gradient-to-br from-gold to-gold-dark rounded-full flex items-center justify-center shadow-md">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        @else
                                            <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-brown to-brown-dark rounded-xl flex items-center justify-center">
                                                <span class="text-2xl sm:text-3xl font-bold text-gold">{{ strtoupper(substr($contestant->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Contestant Info -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base sm:text-lg font-bold text-gray-900 group-hover:text-gold-dark transition-colors mb-1 truncate">
                                            {{ $contestant->name }}
                                        </h3>
                                        <p class="text-gray-400 text-xs font-mono mb-3">
                                            ID: {{ $contestant->id }}
                                        </p>
                                        
                                        <!-- Vote Count -->
                                        <div class="flex items-center gap-2">
                                            <div class="flex items-center gap-1.5 bg-gradient-to-r from-gold/10 to-gold-dark/10 px-3 py-1.5 rounded-lg">
                                                <svg class="w-4 h-4 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-sm font-bold text-gray-900">{{ number_format($contestant->total_votes) }}</span>
                                                <span class="text-xs text-gray-500">votes</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vote Button -->
                                <div class="mt-5 pt-4 border-t border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">Click to vote</span>
                                        <div class="w-10 h-10 bg-gray-50 group-hover:bg-gradient-to-br group-hover:from-gold group-hover:to-gold-dark rounded-full flex items-center justify-center transition-all duration-300">
                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hover Accent Line -->
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-gold to-gold-dark transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                        </a>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-gray-900 mb-2">No Nominees Yet</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Nominees for this category will be announced soon. Stay tuned!</p>
                </div>
            @endif

            <!-- Back Button -->
            <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('events.show', $event->slug) }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:border-gold hover:text-gold-dark transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Categories
                </a>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-gold to-gold-dark text-brown-dark rounded-xl font-semibold hover:shadow-lg transition-all">
                    Browse All Events
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Other Categories Section -->
    @if($event->categories->count() > 1)
        <section class="py-10 lg:py-14 bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-display font-bold text-gray-900">Other Categories</h2>
                    <a href="{{ route('events.show', $event->slug) }}" class="text-gold-dark text-sm font-semibold hover:underline">
                        View All
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($event->categories->where('id', '!=', $category->id)->take(3) as $otherCategory)
                        <a href="{{ route('events.category', [$event->slug, $otherCategory->slug]) }}" 
                           class="group flex items-center justify-between p-4 bg-gray-50 hover:bg-gradient-to-r hover:from-gold/5 hover:to-gold-dark/5 rounded-xl border border-transparent hover:border-gold/20 transition-all">
                            <div>
                                <h3 class="font-semibold text-gray-900 group-hover:text-gold-dark transition-colors">{{ $otherCategory->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $otherCategory->contestants->where('status', 'active')->count() }} nominees</p>
                            </div>
                            <div class="w-8 h-8 bg-white group-hover:bg-gold rounded-full flex items-center justify-center transition-all">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
@endsection