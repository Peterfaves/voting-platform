@extends('layouts.app')

@section('no_padding', true)

@section('title', 'VoteAfrika - The Ultimate Event Voting & Ticketing Platform')
@section('meta_description', 'Transform your events with powerful voting and ticketing. The all-in-one platform for awards shows, talent competitions, and live events.')



@section('content')
    <section class="pt-24 lg:pt-28 pb-16 lg:pb-24 bg-white relative overflow-hidden">
        <!-- Subtle background pattern -->
        <div class="absolute inset-0 opacity-[0.02]">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="hero-grid" width="20" height="20" patternUnits="userSpaceOnUse">
                        <path d="M 20 0 L 0 0 0 20" fill="none" stroke="currentColor" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hero-grid)"/>
            </svg>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Left Content - Text -->
                <div class="fade-in-up">
                    <div class="inline-flex items-center gap-2 bg-gold/10 border border-gold/20 rounded-full px-4 py-2 mb-6">
                        <span class="w-2 h-2 bg-success rounded-full animate-pulse"></span>
                        <span class="text-xs sm:text-sm font-semibold text-gold-dark">Trusted by 50,000+ Event Organizers</span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-display font-bold text-dark mb-6 leading-[1.1] tracking-tight">
                        Transform Your Events with 
                        <span class="text-gradient-gold">Powerful Voting</span>
                    </h1>
                    <p class="text-lg lg:text-xl text-muted mb-8 leading-relaxed max-w-lg">
                        The all-in-one platform for event voting, ticketing, and audience engagement. Perfect for awards shows, talent competitions, and live events.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="btn-primary-lg">
                            Start Free Trial
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="{{ route('home') }}" class="btn-secondary-lg">
                            Browse Events
                        </a>
                    </div>
                    <div class="mt-10 flex flex-wrap items-center gap-6 text-sm text-muted">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            No credit card required
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Setup in 5 minutes
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-success" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            24/7 Support
                        </div>
                    </div>
                </div>

                <!-- Right Content - Professional Image with Lazy Loading -->
                <div class="relative fade-in-up order-first lg:order-last" style="animation-delay: 0.2s;">
                    <div class="relative">
                            <!-- Main Image with Lazy Loading -->
                            <div class="relative z-10 rounded-2xl overflow-hidden shadow-subtle">
                                <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=800&h=600&fit=crop&q=80" 
                                    alt="Professional conference event with audience engagement" 
                                    class="w-full h-auto object-cover"
                                    loading="lazy"
                                    decoding="async"
                                    fetchpriority="high">
                            </div>
                        </div>
                        
                        <!-- Floating Stats Card -->
                        <div class="absolute -bottom-4 -left-4 lg:-left-8 bg-white rounded-xl p-4 shadow-subtle border border-gray-100 z-20">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-display font-bold text-dark">1M+</p>
                                    <p class="text-xs text-muted">Votes Processed</p>
                                </div>
                            </div>
                        </div>

                        <!-- Live Badge -->
                        <div class="absolute -top-3 -right-3 lg:top-4 lg:right-4 bg-gold text-brown-dark px-4 py-2 rounded-full shadow-subtle z-20 font-semibold text-sm flex items-center gap-2">
                            <span class="w-2 h-2 bg-brown-dark rounded-full animate-pulse"></span>
                            Live Voting
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 lg:py-16 bg-cream border-y border-gray-100 lazy-section" data-animate="fade-in-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">
                <div class="text-center stat-item" data-animate="count-up" data-count="50000">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-gold mb-1">50K+</div>
                    <div class="text-muted font-medium text-sm lg:text-base">Active Users</div>
                </div>
                <div class="text-center stat-item" data-animate="count-up" data-count="1000000">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-gold-dark mb-1">1M+</div>
                    <div class="text-muted font-medium text-sm lg:text-base">Votes Cast</div>
                </div>
                <div class="text-center stat-item" data-animate="count-up" data-count="500">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-brown mb-1">500+</div>
                    <div class="text-muted font-medium text-sm lg:text-base">Events Hosted</div>
                </div>
                <div class="text-center stat-item">
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-success mb-1">99.9%</div>
                    <div class="text-muted font-medium text-sm lg:text-base">Uptime</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 lg:py-24 bg-white lazy-section" data-animate="fade-in-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-16">
                <span class="inline-block bg-gold/10 text-gold-dark text-sm font-semibold px-4 py-2 rounded-full mb-4">Features</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-dark mb-4 lg:mb-6">
                    Everything You Need to Run <span class="text-gradient-gold">Amazing Events</span>
                </h2>
                <p class="text-lg text-muted max-w-2xl mx-auto">
                    From voting to ticketing, we've got all the tools to make your event a success
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Feature 1 -->
                <div class="card-clean group lazy-card" data-animate="fade-in-up" style="--delay: 0s;">
                    <div class="bg-gold/10 w-14 h-14 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Real-Time Voting</h3>
                    <p class="text-muted mb-5 leading-relaxed text-sm">
                        Secure, transparent voting system with live results. Your audience can vote instantly from anywhere.
                    </p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Unlimited votes per event
                        </li>
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Real-time leaderboards
                        </li>
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Fraud prevention
                        </li>
                    </ul>
                </div>

                <!-- Feature 2 -->
                <div class="card-clean group lazy-card" data-animate="fade-in-up" style="--delay: 0.1s;">
                    <div class="bg-gold-dark/10 w-14 h-14 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Smart Ticketing</h3>
                    <p class="text-muted mb-5 leading-relaxed text-sm">
                        Sell tickets effortlessly with our integrated ticketing system. Multiple ticket tiers, instant delivery.
                    </p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            QR code tickets
                        </li>
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Email delivery
                        </li>
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Sales analytics
                        </li>
                    </ul>
                </div>

                <!-- Feature 3 -->
                <div class="card-clean group lazy-card" data-animate="fade-in-up" style="--delay: 0.2s;">
                    <div class="bg-brown/10 w-14 h-14 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Powerful Analytics</h3>
                    <p class="text-muted mb-5 leading-relaxed text-sm">
                        Get deep insights into your event performance. Track votes, revenue, and audience engagement.
                    </p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Real-time dashboards
                        </li>
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Export reports
                        </li>
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Revenue tracking
                        </li>
                    </ul>
                </div>

                <!-- Feature 4 -->
                <div class="card-clean group lazy-card" data-animate="fade-in-up" style="--delay: 0.3s;">
                    <div class="bg-success/10 w-14 h-14 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Secure Payments</h3>
                    <p class="text-muted mb-5 leading-relaxed text-sm">
                        Accept payments safely with bank-level security. Multiple payment methods supported.
                    </p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            PCI compliant
                        </li>
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Instant payouts
                        </li>
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Multiple currencies
                        </li>
                    </ul>
                </div>

                <!-- Feature 5 -->
                <div class="card-clean group lazy-card" data-animate="fade-in-up" style="--delay: 0.4s;">
                    <div class="bg-warning/10 w-14 h-14 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Mobile Optimized</h3>
                    <p class="text-muted mb-5 leading-relaxed text-sm">
                        Perfect experience on all devices. Your audience can vote and buy tickets from their phones.
                    </p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Responsive design
                        </li>
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Fast loading
                        </li>
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Touch-friendly
                        </li>
                    </ul>
                </div>

                <!-- Feature 6 -->
                <div class="card-clean group lazy-card" data-animate="fade-in-up" style="--delay: 0.5s;">
                    <div class="bg-gold/10 w-14 h-14 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">24/7 Support</h3>
                    <p class="text-muted mb-5 leading-relaxed text-sm">
                        Our team is always here to help. Get assistance whenever you need it.
                    </p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Live chat support
                        </li>
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Email support
                        </li>
                        <li class="flex items-center gap-2 text-muted">
                            <svg class="w-4 h-4 text-success flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Knowledge base
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-16 lg:py-24 bg-cream lazy-section" data-animate="fade-in-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-16">
                <span class="inline-block bg-gold/10 text-gold-dark text-sm font-semibold px-4 py-2 rounded-full mb-4">How It Works</span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-dark mb-4 lg:mb-6">
                    Get Started in <span class="text-gradient-gold">3 Simple Steps</span>
                </h2>
                <p class="text-lg text-muted max-w-2xl mx-auto">
                    Launch your event and start collecting votes in minutes
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 lg:gap-12 relative">
                <!-- Connection line (desktop only) -->
                <div class="hidden md:block absolute top-10 left-1/4 right-1/4 h-0.5 bg-gradient-to-r from-gold via-gold-dark to-brown"></div>
                
                <div class="text-center relative lazy-card" data-animate="fade-in-up" style="--delay: 0s;">
                    <div class="step-number-clean mx-auto mb-6">1</div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Create Your Event</h3>
                    <p class="text-muted leading-relaxed text-sm">
                        Set up your event details, categories, and contestants in just a few clicks.
                    </p>
                </div>

                <div class="text-center relative lazy-card" data-animate="fade-in-up" style="--delay: 0.15s;">
                    <div class="step-number-clean mx-auto mb-6">2</div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Share & Promote</h3>
                    <p class="text-muted leading-relaxed text-sm">
                        Share your event link with your audience. They can vote instantly from any device.
                    </p>
                </div>

                <div class="text-center relative lazy-card" data-animate="fade-in-up" style="--delay: 0.3s;">
                    <div class="step-number-clean mx-auto mb-6">3</div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Track & Manage</h3>
                    <p class="text-muted leading-relaxed text-sm">
                        Monitor votes in real-time, manage contestants, and track revenue.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 lg:py-20 bg-brown lazy-section" data-animate="fade-in">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                <!-- Left: Text -->
                <div class="lg:max-w-xl">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-white leading-tight">
                        Ready to host or vote? Let's make it happen!
                    </h2>
                </div>
                
                <!-- Right: Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}" class="cta-btn-outline">
                        Host Your Event
                    </a>
                    <a href="{{ route('home') }}" class="cta-btn-solid">
                        Vote Ongoing
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // =============================================
    // LAZY LOADING IMAGES
    // =============================================
    const lazyImages = document.querySelectorAll('.lazy-image');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                const src = img.dataset.src;
                
                if (src) {
                    // Create a new image to preload
                    const newImg = new Image();
                    newImg.onload = function() {
                        img.src = src;
                        img.classList.add('lazy-loaded');
                        img.removeAttribute('data-src');
                    };
                    newImg.src = src;
                }
                
                observer.unobserve(img);
            }
        });
    }, {
        rootMargin: '50px 0px',
        threshold: 0.01
    });
    
    lazyImages.forEach(img => imageObserver.observe(img));

    // =============================================
    // SCROLL ANIMATIONS (Intersection Observer)
    // =============================================
    const animatedElements = document.querySelectorAll('.lazy-section, .lazy-card');
    
    const animationObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = getComputedStyle(entry.target).getPropertyValue('--delay') || '0s';
                entry.target.style.animationDelay = delay;
                entry.target.classList.add('animate-visible');
                animationObserver.unobserve(entry.target);
            }
        });
    }, {
        rootMargin: '0px 0px -50px 0px',
        threshold: 0.1
    });
    
    animatedElements.forEach(el => {
        el.classList.add('animate-hidden');
        animationObserver.observe(el);
    });

    // =============================================
    // HERO SECTION - Immediate animation
    // =============================================
    const heroElements = document.querySelectorAll('.fade-in-up');
    heroElements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.15}s`;
        el.classList.add('animate-visible');
    });
});
</script>
@endpush