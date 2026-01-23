@extends('layouts.app')

@section('title', $event->name . ' - VoteAfrika')
@section('meta_description', $event->description ?? 'Vote for your favorite nominees in ' . $event->name . ' on VoteAfrika.')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-white to-gray-50">
    <!-- Hero Section with Event Header -->
    <section class="relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-[0.02]">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="event-grid" width="20" height="20" patternUnits="userSpaceOnUse">
                        <path d="M 20 0 L 0 0 0 20" fill="none" stroke="currentColor" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#event-grid)"/>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-gold-dark transition-colors">Events</a>
                    </li>
                    <li>
                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li>
                        <span class="text-gray-900 font-medium">{{ $event->name }}</span>
                    </li>
                </ol>
            </nav>

            <!-- Event Card -->
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">
                <div class="lg:flex">
                    <!-- Event Banner/Image -->
                    <div class="lg:w-2/5 relative">
                        <div class="aspect-[4/3] lg:aspect-auto lg:absolute lg:inset-0 bg-gradient-to-br from-brown to-brown-dark flex items-center justify-center p-8">
                            @if($event->banner_image)
                                <img src="{{ asset('storage/' . $event->banner_image) }}" 
                                     alt="{{ $event->name }}"
                                     class="w-full h-full object-cover absolute inset-0">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                            @else
                                <div class="text-center relative z-10">
                                    <div class="w-28 h-28 bg-gradient-to-br from-gold to-gold-dark rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg transform rotate-3">
                                        <svg class="w-14 h-14 text-brown-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-gold text-2xl font-display font-bold tracking-wide">{{ Str::upper(Str::limit($event->name, 20)) }}</h3>
                                </div>
                            @endif
                            
                            <!-- Status Badge -->
                            @if($event->status === 'active')
                                <div class="absolute top-4 left-4 z-20">
                                    <span class="inline-flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                                        <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                        Live Voting
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Event Details -->
                    <div class="lg:w-3/5 p-6 lg:p-10">
                        <!-- Event Title -->
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-gray-900 mb-4 leading-tight">
                            {{ $event->name }}
                        </h1>

                        <!-- Event Meta -->
                        <div class="space-y-3 mb-6">
                            <!-- Date -->
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Event Date</p>
                                    <p class="text-gray-900 font-semibold">{{ $event->start_date->format('F d, Y') }} at {{ $event->start_date->format('g:i A') }}</p>
                                </div>
                            </div>

                            <!-- Vote Price -->
                            <div class="flex items-center gap-3 p-3 bg-gradient-to-r from-gold/10 to-gold-dark/10 rounded-xl border border-gold/20">
                                <div class="w-10 h-10 bg-gradient-to-br from-gold to-gold-dark rounded-lg flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gold-dark font-medium uppercase tracking-wide">Vote Price</p>
                                    <p class="text-gray-900 font-bold text-lg">₦{{ number_format($event->vote_price) }} <span class="text-gray-500 font-normal text-sm">per vote</span></p>
                                </div>
                            </div>

                            <!-- Event ID -->
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Event ID</p>
                                    <p class="text-gray-900 font-mono font-semibold">#{{ $event->id }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        @if($event->description)
                            <div class="pt-5 border-t border-gray-100">
                                <p class="text-gray-600 leading-relaxed">{{ $event->description }}</p>
                            </div>
                        @endif

                        <!-- Tickets CTA -->
                        @if($event->tickets->count() > 0)
                            <div class="mt-6 pt-5 border-t border-gray-100">
                                <a href="{{ route('tickets.show', $event->slug) }}" 
                                   class="inline-flex items-center justify-center gap-2 w-full sm:w-auto bg-gradient-to-r from-gold to-gold-dark text-brown-dark px-6 py-3.5 rounded-xl font-semibold shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                    Buy Event Tickets
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    @if($event->status === 'active')
        @php
            $totalVotes = 0;
            $totalContestants = 0;
            foreach($event->categories as $category) {
                foreach($category->contestants as $contestant) {
                    $totalVotes += $contestant->total_votes;
                }
                $totalContestants += $category->contestants->where('status', 'active')->count();
            }
        @endphp
        <section class="py-8 lg:py-12 border-y border-gray-100 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-3 gap-4 lg:gap-8">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-gold/10 to-gold-dark/10 rounded-xl mb-3">
                            <svg class="w-6 h-6 lg:w-7 lg:h-7 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-gray-900">{{ number_format($totalVotes) }}</div>
                        <div class="text-xs sm:text-sm text-gray-500 font-medium mt-1">Total Votes</div>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-gold/10 to-gold-dark/10 rounded-xl mb-3">
                            <svg class="w-6 h-6 lg:w-7 lg:h-7 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-gray-900">{{ $event->categories->count() }}</div>
                        <div class="text-xs sm:text-sm text-gray-500 font-medium mt-1">Categories</div>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 lg:w-14 lg:h-14 bg-gradient-to-br from-gold/10 to-gold-dark/10 rounded-xl mb-3">
                            <svg class="w-6 h-6 lg:w-7 lg:h-7 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-gray-900">{{ $totalContestants }}</div>
                        <div class="text-xs sm:text-sm text-gray-500 font-medium mt-1">Nominees</div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Categories Section -->
    <section class="py-10 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 bg-gradient-to-br from-gold to-gold-dark rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-display font-bold text-gray-900">
                        {{ $event->status === 'active' ? 'Nomination Categories' : 'Award Categories' }}
                    </h2>
                    <p class="text-gray-500 text-sm mt-0.5">Select a category to view nominees and vote</p>
                </div>
            </div>

            @if($event->categories->count() > 0)
                <div class="grid gap-4">
                    @foreach($event->categories as $category)
                        <a href="{{ route('events.category', [$event->slug, $category->slug]) }}" 
                           class="group block bg-white rounded-xl border border-gray-100 p-5 sm:p-6 hover:border-gold/30 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-gold-dark transition-colors truncate">
                                        {{ $category->name }}
                                    </h3>
                                    @if($category->description)
                                        <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $category->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-4 mt-3">
                                        <span class="inline-flex items-center gap-1.5 text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <span class="font-medium">{{ $category->contestants->where('status', 'active')->count() }}</span> Nominees
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-50 group-hover:bg-gradient-to-br group-hover:from-gold group-hover:to-gold-dark rounded-full flex items-center justify-center transition-all duration-200">
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Categories Yet</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Voting categories will be announced soon. Check back later for updates!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 lg:py-16 bg-gradient-to-br from-brown to-brown-dark">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl font-display font-bold text-white mb-4">
                Ready to Support Your Favorite?
            </h2>
            <p class="text-white/70 mb-8 max-w-2xl mx-auto">
                Browse the categories above and cast your votes for the nominees you believe deserve to win!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white/10 border border-white/30 text-white rounded-xl font-semibold hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Browse More Events
                </a>
                @if($event->categories->count() > 0)
                    <a href="{{ route('events.category', [$event->slug, $event->categories->first()->slug]) }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-brown-dark rounded-xl font-semibold hover:bg-gold transition-all">
                        Start Voting Now
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection