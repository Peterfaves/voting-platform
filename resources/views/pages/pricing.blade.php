@extends('layouts.app')

@section('title', 'Pricing - VoteAfrika')
@section('meta_description', 'VoteAfrika pricing plans. Choose the perfect plan for your event voting and ticketing needs. Start free or upgrade for unlimited features.')

@section('content')
    <!-- Hero Section -->
    <section class="pt-24 lg:pt-32 pb-16 lg:pb-20 hero-gradient relative overflow-hidden">
        <div class="absolute top-20 right-10 w-64 h-64 bg-gold/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 left-10 w-48 h-48 bg-gold/5 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <span class="inline-block bg-gold/10 text-gold-dark text-sm font-semibold px-4 py-2 rounded-full mb-6">Pricing</span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-dark mb-6 leading-tight">
                    Simple, <span class="text-gradient-gold">Transparent</span> Pricing
                </h1>
                <p class="text-base lg:text-xl text-muted leading-relaxed">
                    Choose the plan that works best for your event size. No hidden fees, no surprises.
                </p>
            </div>
        </div>
    </section>

    <!-- Pricing Cards -->
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-6 lg:gap-8 items-start">
                
                <!-- Starter Plan -->
                <div class="pricing-card group">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-display font-bold text-dark mb-2">Starter</h3>
                        <div class="text-4xl lg:text-5xl font-display font-bold text-gold mb-2">Free</div>
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
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-muted">Standard ticketing</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-muted/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-muted" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-muted/50 line-through">Custom branding</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block text-center btn-primary w-full py-3">
                        Get Started Free
                    </a>
                </div>

                <!-- Professional Plan -->
                <div class="pricing-card-featured relative">
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <span class="bg-gradient-gold text-brown-dark px-4 py-1.5 rounded-full text-sm font-bold shadow-gold">
                            MOST POPULAR
                        </span>
                    </div>
                    <div class="text-center mb-8 pt-4">
                        <h3 class="text-2xl font-display font-bold text-white mb-2">Professional</h3>
                        <div class="text-4xl lg:text-5xl font-display font-bold text-white mb-2">₦50,000</div>
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
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-gold/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-gold" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-white/90">Export reports</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="block text-center bg-gradient-gold text-brown-dark px-8 py-3 rounded-full font-semibold hover:shadow-gold transition-all duration-300">
                        Start Pro Trial
                    </a>
                </div>

                <!-- Enterprise Plan -->
                <div class="pricing-card group">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-display font-bold text-dark mb-2">Enterprise</h3>
                        <div class="text-4xl lg:text-5xl font-display font-bold text-gold mb-2">Custom</div>
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
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-muted">SLA guarantee</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-success" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                            <span class="text-muted">24/7 phone support</span>
                        </li>
                    </ul>
                    <a href="mailto:voteafrika@gmail.com?subject=Enterprise%20Inquiry" class="block text-center btn-primary w-full py-3">
                        Contact Sales
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Comparison Table -->
    <section class="py-16 lg:py-24 bg-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-display font-bold text-dark mb-4">
                    Compare Plans
                </h2>
                <p class="text-muted">
                    See what's included in each plan
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full bg-white rounded-2xl shadow-soft overflow-hidden">
                    <thead>
                        <tr class="bg-cream">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-dark">Feature</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-dark">Starter</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gold">Professional</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-dark">Enterprise</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gold/10">
                        <tr>
                            <td class="px-6 py-4 text-muted">Active Events</td>
                            <td class="px-6 py-4 text-center text-dark">1</td>
                            <td class="px-6 py-4 text-center text-dark font-semibold">5</td>
                            <td class="px-6 py-4 text-center text-dark">Unlimited</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-muted">Votes per Event</td>
                            <td class="px-6 py-4 text-center text-dark">1,000</td>
                            <td class="px-6 py-4 text-center text-dark font-semibold">Unlimited</td>
                            <td class="px-6 py-4 text-center text-dark">Unlimited</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-muted">Categories per Event</td>
                            <td class="px-6 py-4 text-center text-dark">5</td>
                            <td class="px-6 py-4 text-center text-dark font-semibold">Unlimited</td>
                            <td class="px-6 py-4 text-center text-dark">Unlimited</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-muted">Contestants per Category</td>
                            <td class="px-6 py-4 text-center text-dark">10</td>
                            <td class="px-6 py-4 text-center text-dark font-semibold">Unlimited</td>
                            <td class="px-6 py-4 text-center text-dark">Unlimited</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-muted">Analytics</td>
                            <td class="px-6 py-4 text-center text-dark">Basic</td>
                            <td class="px-6 py-4 text-center text-dark font-semibold">Advanced</td>
                            <td class="px-6 py-4 text-center text-dark">Custom</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-muted">Custom Branding</td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-muted/30 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-success mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-success mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-muted">Export Reports</td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-muted/30 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-success mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-success mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-muted">Support</td>
                            <td class="px-6 py-4 text-center text-dark">Email</td>
                            <td class="px-6 py-4 text-center text-dark font-semibold">Priority</td>
                            <td class="px-6 py-4 text-center text-dark">24/7 Phone</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-muted">API Access</td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-muted/30 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-muted/30 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg class="w-5 h-5 text-success mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-display font-bold text-dark mb-4">
                    Frequently Asked Questions
                </h2>
            </div>

            <div class="space-y-4">
                <div class="bg-cream rounded-2xl p-6">
                    <h3 class="font-semibold text-dark mb-2">Can I upgrade or downgrade my plan?</h3>
                    <p class="text-muted text-sm">Yes! You can upgrade or downgrade your plan at any time. Changes take effect immediately, and we'll prorate your billing accordingly.</p>
                </div>
                <div class="bg-cream rounded-2xl p-6">
                    <h3 class="font-semibold text-dark mb-2">What payment methods do you accept?</h3>
                    <p class="text-muted text-sm">We accept bank transfers, card payments (Visa, Mastercard), and mobile money. All payments are processed securely through our trusted payment partners.</p>
                </div>
                <div class="bg-cream rounded-2xl p-6">
                    <h3 class="font-semibold text-dark mb-2">Is there a free trial for the Professional plan?</h3>
                    <p class="text-muted text-sm">Yes! You get a 14-day free trial of the Professional plan. No credit card required. If you don't upgrade, you'll automatically switch to the Starter plan.</p>
                </div>
                <div class="bg-cream rounded-2xl p-6">
                    <h3 class="font-semibold text-dark mb-2">What happens when I reach my vote limit?</h3>
                    <p class="text-muted text-sm">On the Starter plan, voting will pause when you reach 1,000 votes. You can upgrade to Professional for unlimited votes, or wait until your next billing cycle.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 lg:py-20 cta-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-white mb-4">
                Ready to Get Started?
            </h2>
            <p class="text-gold/80 mb-8 max-w-xl mx-auto">
                Join thousands of event organizers who trust VoteAfrika for their events.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-gradient-gold text-brown-dark px-8 py-3 rounded-full font-semibold hover:shadow-gold transition-all duration-300">
                    Start Free Trial
                </a>
                <a href="{{ route('contact') }}" class="bg-transparent border-2 border-gold text-gold px-8 py-3 rounded-full font-semibold hover:bg-gold hover:text-brown-dark transition-all duration-300">
                    Contact Sales
                </a>
            </div>
        </div>
    </section>
@endsection