@extends('layouts.app')

@section('title', 'Vote for ' . $contestant->name . ' | VoteAfrika')
@section('meta_description', 'Cast your vote for ' . $contestant->name . ' in ' . $contestant->category->name . ' at ' . $contestant->category->event->name)

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white py-8 lg:py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Link -->
        <a href="{{ route('events.category', [$contestant->category->event->slug, $contestant->category->slug]) }}" 
           class="inline-flex items-center gap-2 text-gray-500 hover:text-gold-dark transition-colors mb-6 group">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium">Back to Nominees</span>
        </a>

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-display font-bold text-gray-900 mb-2">Cast Your Vote</h1>
            <p class="text-gray-500">Support your favorite nominee with your vote</p>
        </div>

        <!-- Main Grid -->
        <div class="grid lg:grid-cols-5 gap-6 lg:gap-8">
            
            <!-- Left Column - Nominee & Event Info -->
            <div class="lg:col-span-2 space-y-5">
                
                <!-- Nominee Card -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                        <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Voting For</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex gap-4">
                            <!-- Photo -->
                            <div class="flex-shrink-0">
                                @if($contestant->photo)
                                    <img src="{{ asset('storage/' . $contestant->photo) }}" 
                                         alt="{{ $contestant->name }}"
                                         class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-xl border-2 border-gray-100">
                                @else
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-brown to-brown-dark rounded-xl flex items-center justify-center">
                                        <span class="text-2xl sm:text-3xl font-bold text-gold">{{ strtoupper(substr($contestant->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold text-gray-900 mb-1 truncate">{{ $contestant->name }}</h3>
                                <p class="text-sm text-gray-400 font-mono mb-2">ID: {{ $contestant->id }}</p>
                                <div class="inline-flex items-center gap-1.5 bg-gradient-to-r from-gold/10 to-gold-dark/10 px-3 py-1.5 rounded-lg">
                                    <svg class="w-4 h-4 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-bold text-gray-900">{{ number_format($contestant->total_votes) }}</span>
                                    <span class="text-xs text-gray-500">votes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Card -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
                        <h2 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Event</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex gap-4">
                            <!-- Image -->
                            <div class="flex-shrink-0">
                                @if($contestant->category->event->banner_image)
                                    <img src="{{ asset('storage/' . $contestant->category->event->banner_image) }}" 
                                         alt="{{ $contestant->category->event->name }}"
                                         class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-xl border-2 border-gray-100">
                                @else
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-brown to-brown-dark rounded-xl flex items-center justify-center">
                                        <svg class="w-10 h-10 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold text-gray-900 mb-1 truncate">{{ $contestant->category->event->name }}</h3>
                                <p class="text-sm text-gray-500 mb-2">{{ $contestant->category->name }}</p>
                                <p class="text-xs text-gray-400">
                                    <span class="font-medium">Organized by:</span> {{ $contestant->category->event->user->name ?? 'Event Organizer' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vote Price Info -->
                <div class="bg-gradient-to-br from-gold/10 to-gold-dark/10 rounded-2xl p-5 border border-gold/20">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Vote Price</p>
                            <p class="text-2xl font-display font-bold text-gray-900">₦{{ number_format($contestant->category->event->vote_price) }} <span class="text-sm font-normal text-gray-500">per vote</span></p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column - Voting Form -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-brown to-brown-dark">
                        <h2 class="text-lg font-display font-bold text-white">Complete Your Vote</h2>
                        <p class="text-white/60 text-sm mt-1">Fill in the details below to cast your vote</p>
                    </div>
                    
                    <form method="POST" action="{{ route('voting.initiate', $contestant) }}" id="votingForm" class="p-6">
                        @csrf
                        
                        <!-- Number of Votes -->
                        <div class="mb-6">
                            <label for="number_of_votes" class="block text-sm font-semibold text-gray-700 mb-2">
                                Number of Votes <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                    name="number_of_votes" 
                                    id="number_of_votes"
                                    min="1" 
                                    max="1000" 
                                    value="{{ old('number_of_votes', 1) }}" 
                                    required
                                    class="w-full px-4 py-3.5 border-2 border-gray-200 rounded-xl text-lg font-semibold text-gray-900 focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/20 transition-all"
                                    onchange="updateTotal()"
                                    oninput="updateTotal()">
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">votes</div>
                            </div>
                            @error('number_of_votes')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Amount Display -->
                        <div class="mb-6 p-5 bg-gradient-to-r from-gold/10 to-gold-dark/10 rounded-xl border border-gold/30">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 font-medium">Total Amount</span>
                                <span id="total_amount" class="text-2xl font-display font-bold text-gray-900">
                                    ₦{{ number_format($contestant->category->event->vote_price, 2) }}
                                </span>
                            </div>
                        </div>

                        <div class="h-px bg-gray-100 my-6"></div>

                        <!-- Voter Information Section -->
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Your Information</h3>

                        <!-- Name -->
                        <div class="mb-5">
                            <label for="voter_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                name="voter_name"
                                id="voter_name"
                                required
                                value="{{ old('voter_name', auth()->user()->name ?? '') }}"
                                placeholder="Enter your full name"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/20 transition-all">
                            @error('voter_name')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-5">
                            <label for="voter_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                name="voter_email"
                                id="voter_email"
                                required
                                value="{{ old('voter_email', auth()->user()->email ?? '') }}"
                                placeholder="your@email.com"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/20 transition-all">
                            @error('voter_email')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-6">
                            <label for="voter_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                Phone Number <span class="text-gray-400 font-normal">(optional)</span>
                            </label>
                            <input type="tel" 
                                name="voter_phone"
                                id="voter_phone"
                                value="{{ old('voter_phone', auth()->user()->phone ?? '') }}"
                                placeholder="+234 800 000 0000"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-900 placeholder-gray-400 focus:outline-none focus:border-gold focus:ring-2 focus:ring-gold/20 transition-all">
                            @error('voter_phone')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                id="voteButton"
                                class="w-full bg-gradient-to-r from-gold to-gold-dark text-brown-dark font-bold py-4 px-6 rounded-xl text-lg hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            Vote Now
                        </button>

                        <!-- Security Badge -->
                        <div class="mt-5 flex items-center justify-center gap-2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <span class="text-sm">Secure payment powered by Paystack</span>
                        </div>
                    </form>
                </div>

                <!-- Trust Badges -->
                <div class="mt-6 grid grid-cols-3 gap-4">
                    <div class="flex flex-col items-center text-center p-4 bg-white rounded-xl border border-gray-100">
                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-gray-600">Secure</span>
                    </div>
                    <div class="flex flex-col items-center text-center p-4 bg-white rounded-xl border border-gray-100">
                        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-gray-600">Instant</span>
                    </div>
                    <div class="flex flex-col items-center text-center p-4 bg-white rounded-xl border border-gray-100">
                        <div class="w-10 h-10 bg-gold/10 rounded-lg flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium text-gray-600">Verified</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateTotal() {
        const voteCount = parseFloat(document.getElementById('number_of_votes').value) || 1;
        const pricePerVote = {{ $contestant->category->event->vote_price }};
        const total = voteCount * pricePerVote;
        
        // Format with thousands separator
        const formatted = new Intl.NumberFormat('en-NG', {
            style: 'currency',
            currency: 'NGN',
            minimumFractionDigits: 2
        }).format(total);
        
        document.getElementById('total_amount').textContent = formatted;
    }
    
    // Initialize on load
    document.addEventListener('DOMContentLoaded', function() {
        updateTotal();
    });
</script>
@endpush
@endsection