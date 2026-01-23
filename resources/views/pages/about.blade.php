@extends('layouts.app')

@section('title', 'About Us - VoteAfrika')
@section('meta_description', 'Learn about VoteAfrika - the leading event voting and ticketing platform by VoteAfrika Media Services. Our mission, team, and story.')

@section('content')
    <!-- Hero Section -->
    <section class="pt-24 lg:pt-32 pb-16 lg:pb-20 hero-gradient relative overflow-hidden">
        <div class="absolute top-20 right-10 w-64 h-64 bg-gold/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <span class="inline-block bg-gold/10 text-gold-dark text-sm font-semibold px-4 py-2 rounded-full mb-6">About Us</span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-dark mb-6 leading-tight">
                    Empowering Events with <span class="text-gradient-gold">Innovative Technology</span>
                </h1>
                <p class="text-base lg:text-xl text-muted leading-relaxed">
                    VoteAfrika is a product of VoteAfrika Media Services, dedicated to transforming how events engage with their audiences through seamless voting and ticketing solutions.
                </p>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <span class="inline-block bg-gold/10 text-gold-dark text-sm font-semibold px-4 py-2 rounded-full mb-4">Our Story</span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-dark mb-6">
                        From Vision to Reality
                    </h2>
                    <div class="space-y-4 text-muted leading-relaxed">
                        <p>
                            VoteAfrika was born out of a simple observation: event organizers needed a better way to engage their audiences and manage voting processes. Traditional methods were cumbersome, prone to fraud, and lacked the real-time excitement that modern events demand.
                        </p>
                        <p>
                            Founded by VoteAfrika Media Services, we set out to create a platform that would revolutionize event voting and ticketing. Our team of passionate developers and event enthusiasts worked tirelessly to build a solution that is secure, scalable, and incredibly easy to use.
                        </p>
                        <p>
                            Today, VoteAfrika powers hundreds of events across Nigeria and beyond, from local talent shows to major awards ceremonies. We're proud to be the trusted choice for event organizers who want to deliver exceptional experiences.
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-cream rounded-3xl p-8 lg:p-12">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&h=400&fit=crop" 
                             alt="Team collaboration" 
                             class="rounded-2xl w-full shadow-premium">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-gradient-gold text-brown-dark px-6 py-4 rounded-2xl shadow-gold">
                        <div class="text-3xl font-display font-bold">2023</div>
                        <div class="text-sm">Founded</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Values -->
    <section class="py-16 lg:py-24 bg-cream">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 lg:mb-16">
                <span class="inline-block bg-gold/10 text-gold-dark text-sm font-semibold px-4 py-2 rounded-full mb-4">Our Values</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-dark mb-6">
                    What Drives Us
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Value 1 -->
                <div class="card-premium text-center">
                    <div class="bg-gold/10 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Trust & Security</h3>
                    <p class="text-muted text-sm leading-relaxed">
                        We prioritize the security of every vote and transaction. Our platform uses industry-leading encryption and fraud prevention measures.
                    </p>
                </div>

                <!-- Value 2 -->
                <div class="card-premium text-center">
                    <div class="bg-gold-dark/10 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Innovation</h3>
                    <p class="text-muted text-sm leading-relaxed">
                        We continuously improve our platform with new features and technologies to stay ahead of industry trends and user needs.
                    </p>
                </div>

                <!-- Value 3 -->
                <div class="card-premium text-center">
                    <div class="bg-success/10 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Customer First</h3>
                    <p class="text-muted text-sm leading-relaxed">
                        Our customers are at the heart of everything we do. We listen, adapt, and deliver solutions that exceed expectations.
                    </p>
                </div>

                <!-- Value 4 -->
                <div class="card-premium text-center">
                    <div class="bg-warning/10 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Simplicity</h3>
                    <p class="text-muted text-sm leading-relaxed">
                        We believe powerful tools should be simple to use. Our intuitive interface makes event management accessible to everyone.
                    </p>
                </div>

                <!-- Value 5 -->
                <div class="card-premium text-center">
                    <div class="bg-brown/10 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Accessibility</h3>
                    <p class="text-muted text-sm leading-relaxed">
                        We're committed to making event participation available to everyone, regardless of location or device.
                    </p>
                </div>

                <!-- Value 6 -->
                <div class="card-premium text-center">
                    <div class="bg-gold/10 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-display font-bold text-dark mb-3">Passion</h3>
                    <p class="text-muted text-sm leading-relaxed">
                        We love what we do, and it shows in every feature we build and every customer we serve.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold text-dark mb-4">
                    Our Impact in Numbers
                </h2>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-3xl lg:text-5xl font-display font-bold text-gold mb-2">500+</div>
                    <div class="text-muted">Events Hosted</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl lg:text-5xl font-display font-bold text-gold-dark mb-2">1M+</div>
                    <div class="text-muted">Votes Processed</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl lg:text-5xl font-display font-bold text-brown mb-2">50K+</div>
                    <div class="text-muted">Happy Users</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl lg:text-5xl font-display font-bold text-success mb-2">24/7</div>
                    <div class="text-muted">Support Available</div>
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
                    Create Your Event
                </a>
                <a href="{{ route('contact') }}" class="bg-transparent border-2 border-gold text-gold px-8 py-3 rounded-full font-semibold hover:bg-gold hover:text-brown-dark transition-all duration-300">
                    Contact Us
                </a>
            </div>
        </div>
    </section>
@endsection