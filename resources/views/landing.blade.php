<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoteAfrika - The Ultimate Event Voting & Ticketing Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream font-body text-dark antialiased">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white/95 backdrop-blur-md shadow-soft z-50 border-b border-gold/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-18">
                <div class="flex items-center">
                    <a href="{{ route('landing') }}" class="text-2xl font-display font-bold text-gradient-gold">
                        VoteAfrika
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-muted hover:text-gold-dark font-medium transition-all duration-300 hover:-translate-y-0.5">Features</a>
                    <a href="#how-it-works" class="text-muted hover:text-gold-dark font-medium transition-all duration-300 hover:-translate-y-0.5">How It Works</a>
                    <a href="#pricing" class="text-muted hover:text-gold-dark font-medium transition-all duration-300 hover:-translate-y-0.5">Pricing</a>
                    <a href="{{ route('home') }}" class="text-muted hover:text-gold-dark font-medium transition-all duration-300 hover:-translate-y-0.5">Browse Events</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-muted hover:text-gold-dark font-medium transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-muted hover:text-gold-dark font-medium transition-colors">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-24 hero-gradient relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-gold/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-gold/5 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="fade-in">
                    <div class="inline-flex items-center gap-2 bg-gold/10 border border-gold/20 rounded-full px-4 py-2 mb-6">
                        <span class="w-2 h-2 bg-success rounded-full animate-pulse"></span>
                        <span class="text-sm font-semibold text-gold-dark">Trusted by 50,000+ Event Organizers</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-display font-bold text-dark mb-6 leading-tight tracking-tight">
                        Transform Your Events with 
                        <span class="text-gradient-gold">
                            Powerful Voting
                        </span>
                    </h1>
                    <p class="text-xl text-muted mb-8 leading-relaxed">
                        The all-in-one platform for event voting, ticketing, and audience engagement. Perfect for awards shows, talent competitions, and live events.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-4">
                            Start Free Trial
                            <svg class="w-5 h-5 ml-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="{{ route('home') }}" class="btn-secondary text-lg px-8 py-4">
                            Browse Events
                        </a>
                    </div>
                    <div class="mt-10 flex items-center gap-8 text-sm text-muted">
                        <div class="flex items-center gap-2">
                            <div class="w-5 h-5 rounded-full bg-success/20 flex items-center justify-center">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            No credit card required
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-5 h-5 rounded-full bg-success/20 flex items-center justify-center">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            Setup in 5 minutes
                        </div>
                    </div>
                </div>
                <div class="relative fade-in">
                    <div class="relative z-10 bg-white rounded-3xl shadow-premium p-6 transform rotate-2 hover:rotate-0 transition-all duration-500 border border-gold/10">
                        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&h=600&fit=crop" 
                             alt="Event" 
                             class="rounded-2xl w-full object-cover">
                    </div>
                    <div class="absolute -top-4 -left-4 bg-gradient-gold text-brown-dark px-5 py-3 rounded-2xl shadow-gold z-20 font-semibold">
                        <span class="mr-1">🎉</span> Live Voting
                    </div>
                    <div class="absolute -bottom-4 -right-4 bg-white px-6 py-4 rounded-2xl shadow-premium z-20 border border-gold/10">
                        <span class="text-3xl font-display font-bold text-gold">10,000+</span>
                        <span class="text-sm text-muted ml-2">Votes Cast</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white border-y border-gold/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="text-4xl md:text-5xl font-display font-bold text-gold mb-2 group-hover:scale-110 transition-transform duration-300">50K+</div>
                    <div class="text-muted font-medium">Active Users</div>
                </div>
                <div class="text-center group">
                    <div class="text-4xl md:text-5xl font-display font-bold text-gold-dark mb-2 group-hover:scale-110 transition-transform duration-300">1M+</div>
                    <div class="text-muted font-medium">Votes Cast</div>
                </div>
                <div class="text-center group">
                    <div class="text-4xl md:text-5xl font-display font-bold text-brown mb-2 group-hover:scale-110 transition-transform duration-300">500+</div>
                    <div class="text-muted font-medium">Events Hosted</div>
                </div>
                <div class="text-center group">
                    <div class="text-4xl md:text-5xl font-display font-bold text-success mb-2 group-hover:scale-110 transition-transform duration-300">99.9%</div>
                    <div class="text-muted font-medium">Uptime</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block bg-gold/10 text-gold-dark text-sm font-semibold px-4 py-2 rounded-full mb-4">Features</span>
                <h2 class="text-4xl md:text-5xl font-display font-bold text-dark mb-6">
                    Everything You Need to Run <span class="text-gradient-gold">Amazing Events</span>
                </h2>
                <p class="text-xl text-muted max-w-2xl mx-auto">
                    From voting to ticketing, we've got all the tools to make your event a success
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="card-premium group">
                    <div class="bg-gold/10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-gold/20 transition-colors duration-300">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-display font-bold text-dark mb-4">Real-Time Voting</h3>
                    <p class="text-muted mb-6 leading-relaxed">
                        Secure, transparent voting system with live results. Your audience can vote instantly from anywhere.
                    </p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Unlimited votes per event
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Real-time leaderboards
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Fraud prevention
                        </li>
                    </ul>
                </div>

                <!-- Feature 2 -->
                <div class="card-premium group">
                    <div class="bg-gold-dark/10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-gold-dark/20 transition-colors duration-300">
                        <svg class="w-8 h-8 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-display font-bold text-dark mb-4">Smart Ticketing</h3>
                    <p class="text-muted mb-6 leading-relaxed">
                        Sell tickets effortlessly with our integrated ticketing system. Multiple ticket tiers, instant delivery.
                    </p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            QR code tickets
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Email delivery
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Sales analytics
                        </li>
                    </ul>
                </div>

                <!-- Feature 3 -->
                <div class="card-premium group">
                    <div class="bg-brown/10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-brown/20 transition-colors duration-300">
                        <svg class="w-8 h-8 text-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-display font-bold text-dark mb-4">Powerful Analytics</h3>
                    <p class="text-muted mb-6 leading-relaxed">
                        Get deep insights into your event performance. Track votes, revenue, and audience engagement.
                    </p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Real-time dashboards
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Export reports
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Revenue tracking
                        </li>
                    </ul>
                </div>

                <!-- Feature 4 -->
                <div class="card-premium group">
                    <div class="bg-success/10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-success/20 transition-colors duration-300">
                        <svg class="w-8 h-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-display font-bold text-dark mb-4">Secure Payments</h3>
                    <p class="text-muted mb-6 leading-relaxed">
                        Accept payments safely with bank-level security. Multiple payment methods supported.
                    </p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            PCI compliant
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Instant payouts
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Multiple currencies
                        </li>
                    </ul>
                </div>

                <!-- Feature 5 -->
                <div class="card-premium group">
                    <div class="bg-warning/10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-warning/20 transition-colors duration-300">
                        <svg class="w-8 h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-display font-bold text-dark mb-4">Mobile Optimized</h3>
                    <p class="text-muted mb-6 leading-relaxed">
                        Perfect experience on all devices. Your audience can vote and buy tickets from their phones.
                    </p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Responsive design
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Fast loading
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Touch-friendly
                        </li>
                    </ul>
                </div>

                <!-- Feature 6 -->
                <div class="card-premium group">
                    <div class="bg-gold/10 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-gold/20 transition-colors duration-300">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-display font-bold text-dark mb-4">24/7 Support</h3>
                    <p class="text-muted mb-6 leading-relaxed">
                        Our team is always here to help. Get assistance whenever you need it.
                    </p>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Live chat support
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Email support
                        </li>
                        <li class="flex items-center gap-3 text-muted">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            Knowledge base
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-block bg-gold/10 text-gold-dark text-sm font-semibold px-4 py-2 rounded-full mb-4">How It Works</span>
                <h2 class="text-4xl md:text-5xl font-display font-bold text-dark mb-6">
                    Get Started in <span class="text-gradient-gold">3 Simple Steps</span>
                </h2>
                <p class="text-xl text-muted max-w-2xl mx-auto">
                    Launch your event and start collecting votes in minutes
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-12 relative">
                <!-- Connection line -->
                <div class="hidden md:block absolute top-10 left-1/4 right-1/4 h-0.5 bg-gradient-to-r from-gold via-gold-dark to-brown"></div>
                
                <div class="text-center relative">
                    <div class="step-number mx-auto mb-8">
                        1
                    </div>
                    <h3 class="text-2xl font-display font-bold text-dark mb-4">Create Your Event</h3>
                    <p class="text-muted leading-relaxed">
                        Set up your event details, categories, and contestants in just a few clicks. Customize everything to match your brand.
                    </p>
                </div>

                <div class="text-center relative">
                    <div class="step-number mx-auto mb-8" style="background: linear-gradient(135deg, #C9A400 0%, #E6C200 100%);">
                        2
                    </div>
                    <h3 class="text-2xl font-display font-bold text-dark mb-4">Share & Promote</h3>
                    <p class="text-muted leading-relaxed">
                        Share your event link with your audience. They can vote and buy tickets instantly from any device.
                    </p>
                </div>

                <div class="text-center relative">
                    <div class="step-number mx-auto mb-8" style="background: linear-gradient(135deg, #4A3B00 0%, #C9A400 100%);">
                        3
                    </div>
                    <h3 class="text-2xl font-display font-bold text-dark mb-4">Track & Manage</h3>
                    <p class="text-muted leading-relaxed">
                        Monitor votes in real-time, manage contestants, and track revenue from your powerful dashboard.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-24 pricing-gradient relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 left-0 w-full h-full opacity-30">
            <div class="absolute top-20 left-20 w-64 h-64 bg-gold/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-80 h-80 bg-gold-dark/20 rounded-full blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block bg-gold/10 text-gold-dark text-sm font-semibold px-4 py-2 rounded-full mb-4">Pricing</span>
                <h2 class="text-4xl md:text-5xl font-display font-bold text-dark mb-6">
                    Simple, <span class="text-gradient-gold">Transparent</span> Pricing
                </h2>
                <p class="text-xl text-muted max-w-2xl mx-auto">
                    Choose the plan that works best for your event size
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 items-start">
                <!-- Starter Plan -->
                <div class="pricing-card group">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-display font-bold text-dark mb-2">Starter</h3>
                        <div class="text-5xl font-display font-bold text-gold mb-2">Free</div>
                        <p class="text-muted">Perfect for small events</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-muted">Up to 1,000 votes</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-muted">1 Active event</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-muted">Basic analytics</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-muted">Email support</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block text-center btn-primary w-full">
                        Get Started Free
                    </a>
                </div>

                <!-- Pro Plan - Featured -->
                <div class="pricing-card-featured relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-gradient-gold text-brown-dark px-4 py-1.5 rounded-full text-sm font-bold shadow-gold">
                            MOST POPULAR
                        </span>
                    </div>
                    <div class="text-center mb-8 pt-4">
                        <h3 class="text-2xl font-display font-bold text-white mb-2">Professional</h3>
                        <div class="text-5xl font-display font-bold text-white mb-2">₦50,000</div>
                        <p class="text-gold/80">Per month</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-gold/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-white/90">Unlimited votes</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-gold/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-white/90">5 Active events</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-gold/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-white/90">Advanced analytics</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-gold/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-white/90">Priority support</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-gold/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-white/90">Custom branding</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block text-center bg-gradient-gold text-brown-dark px-8 py-3 rounded-full font-semibold hover:shadow-gold transition-all duration-300 hover:-translate-y-0.5">
                        Start Pro Trial
                    </a>
                </div>

                <!-- Enterprise Plan -->
                <div class="pricing-card group">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-display font-bold text-dark mb-2">Enterprise</h3>
                        <div class="text-5xl font-display font-bold text-gold mb-2">Custom</div>
                        <p class="text-muted">For large organizations</p>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-muted">Unlimited everything</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-muted">White-label solution</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-muted">Dedicated account manager</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-muted">Custom integrations</span>
                        </li>
                    </ul>
                    <a href="mailto:sales@voteafrika.com" class="block text-center btn-primary w-full">
                        Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 cta-gradient relative overflow-hidden">
        <!-- Decorative pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)"/>
            </svg>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-display font-bold text-white mb-6">
                Ready to Create Your First Event?
            </h2>
            <p class="text-xl text-gold/80 mb-10 max-w-2xl mx-auto">
                Join thousands of event organizers who trust VoteAfrika for their voting and ticketing needs.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-gradient-gold text-brown-dark px-10 py-4 rounded-full text-lg font-semibold hover:shadow-gold transition-all duration-300 hover:-translate-y-1 hover:scale-105">
                    Start Free Trial
                </a>
                <a href="{{ route('home') }}" class="bg-transparent border-2 border-gold text-gold px-10 py-4 rounded-full text-lg font-semibold hover:bg-gold hover:text-brown-dark transition-all duration-300">
                    View Live Events
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brown text-cream/70 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <h3 class="text-gold text-2xl font-display font-bold mb-4">VoteAfrika</h3>
                    <p class="text-sm leading-relaxed">
                        The ultimate platform for event voting and ticketing. Trusted by event organizers worldwide.
                    </p>
                    <div class="flex gap-4 mt-6">
                        <a href="#" class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center hover:bg-gold/20 transition-colors">
                            <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center hover:bg-gold/20 transition-colors">
                            <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center hover:bg-gold/20 transition-colors">
                            <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-gold font-semibold mb-4">Product</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#features" class="hover:text-gold transition-colors">Features</a></li>
                        <li><a href="#pricing" class="hover:text-gold transition-colors">Pricing</a></li>
                        <li><a href="{{ route('home') }}" class="hover:text-gold transition-colors">Browse Events</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-gold font-semibold mb-4">Company</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-gold transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-gold transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-gold transition-colors">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-gold font-semibold mb-4">Legal</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-gold transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-gold transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gold/20 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} VoteAfrika. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>