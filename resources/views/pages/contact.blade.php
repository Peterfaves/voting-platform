@extends('layouts.app')

@section('title', 'Contact Us - VoteAfrika')
@section('meta_description', 'Get in touch with VoteAfrika. We\'re here to help with your event voting and ticketing needs. Reach out via email, phone, or our contact form.')

@section('content')
    <!-- Hero Section -->
    <section class="pt-24 lg:pt-32 pb-16 lg:pb-20 hero-gradient relative overflow-hidden">
        <div class="absolute top-20 left-10 w-64 h-64 bg-gold/10 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <span class="inline-block bg-gold/10 text-gold-dark text-sm font-semibold px-4 py-2 rounded-full mb-6">Contact Us</span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-display font-bold text-dark mb-6 leading-tight">
                    We'd Love to <span class="text-gradient-gold">Hear From You</span>
                </h1>
                <p class="text-base lg:text-xl text-muted leading-relaxed">
                    Have questions about VoteAfrika? Need help with your event? Our team is here to assist you every step of the way.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16">
                <!-- Contact Information -->
                <div>
                    <h2 class="text-2xl sm:text-3xl font-display font-bold text-dark mb-6">
                        Get in Touch
                    </h2>
                    <p class="text-muted mb-8 leading-relaxed">
                        Whether you have a question about features, pricing, or anything else, our team is ready to answer all your questions.
                    </p>

                    <div class="space-y-6">
                        <!-- Email -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-gold/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-dark mb-1">Email</h3>
                                <a href="mailto:voteafrika@gmail.com" class="text-muted hover:text-gold transition-colors">
                                    voteafrika@gmail.com
                                </a>
                                <p class="text-sm text-muted mt-1">We'll respond within 24 hours</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-gold-dark/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gold-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-dark mb-1">Phone</h3>
                                <a href="tel:0554047563" class="text-muted hover:text-gold transition-colors">
                                    0554047563
                                </a>
                                <p class="text-sm text-muted mt-1">Mon-Fri from 9am to 6pm WAT</p>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-brown/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-brown" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-dark mb-1">Location</h3>
                                <p class="text-muted">Lagos, Nigeria</p>
                                <p class="text-sm text-muted mt-1">Serving clients worldwide</p>
                            </div>
                        </div>

                        <!-- Support Hours -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-success/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-dark mb-1">Support Hours</h3>
                                <p class="text-muted">24/7 Available</p>
                                <p class="text-sm text-muted mt-1">For urgent event-day support</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="mt-10 pt-8 border-t border-gold/10">
                        <h3 class="font-semibold text-dark mb-4">Follow Us</h3>
                        <div class="flex gap-3">
                            <a href="#" class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center text-gold hover:bg-gold hover:text-brown-dark transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center text-gold hover:bg-gold hover:text-brown-dark transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gold/10 flex items-center justify-center text-gold hover:bg-gold hover:text-brown-dark transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div>
                    <div class="bg-cream rounded-3xl p-6 lg:p-10">
                        <h2 class="text-2xl font-display font-bold text-dark mb-6">
                            Send us a Message
                        </h2>

                        @if(session('success'))
                            <div class="alert alert-success mb-6">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                            @csrf
                            
                            <div class="grid sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-dark mb-2">Full Name</label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           class="form-input" 
                                           placeholder="John Doe"
                                           value="{{ old('name') }}"
                                           required>
                                    @error('name')
                                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-dark mb-2">Email Address</label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           class="form-input" 
                                           placeholder="john@example.com"
                                           value="{{ old('email') }}"
                                           required>
                                    @error('email')
                                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-dark mb-2">Phone Number (Optional)</label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       class="form-input" 
                                       placeholder="+234 xxx xxx xxxx"
                                       value="{{ old('phone') }}">
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-dark mb-2">Subject</label>
                                <select id="subject" name="subject" class="form-select" required>
                                    <option value="">Select a topic</option>
                                    <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                    <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>Technical Support</option>
                                    <option value="sales" {{ old('subject') == 'sales' ? 'selected' : '' }}>Sales & Pricing</option>
                                    <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>Partnership Opportunities</option>
                                    <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Feedback & Suggestions</option>
                                </select>
                                @error('subject')
                                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-dark mb-2">Message</label>
                                <textarea id="message" 
                                          name="message" 
                                          rows="5" 
                                          class="form-input resize-none" 
                                          placeholder="How can we help you?"
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="btn-primary w-full py-4">
                                Send Message
                                <svg class="w-5 h-5 ml-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 lg:py-24 bg-cream">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block bg-gold/10 text-gold-dark text-sm font-semibold px-4 py-2 rounded-full mb-4">FAQ</span>
                <h2 class="text-2xl sm:text-3xl font-display font-bold text-dark mb-4">
                    Frequently Asked Questions
                </h2>
                <p class="text-muted">
                    Can't find what you're looking for? Reach out to us directly.
                </p>
            </div>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-2xl border border-gold/10 overflow-hidden">
                    <button class="faq-toggle w-full px-6 py-5 text-left flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-dark">How quickly can I set up an event?</span>
                        <svg class="w-5 h-5 text-gold transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-muted">You can set up a complete event with voting categories and ticketing in as little as 5 minutes. Our intuitive interface guides you through every step of the process.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-2xl border border-gold/10 overflow-hidden">
                    <button class="faq-toggle w-full px-6 py-5 text-left flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-dark">What payment methods do you support?</span>
                        <svg class="w-5 h-5 text-gold transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-muted">We support multiple payment methods including bank transfers, card payments, and mobile money. Payments are processed securely through trusted payment gateways.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-2xl border border-gold/10 overflow-hidden">
                    <button class="faq-toggle w-full px-6 py-5 text-left flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-dark">Is there a limit on the number of votes?</span>
                        <svg class="w-5 h-5 text-gold transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-muted">The free plan supports up to 1,000 votes per event. For unlimited votes, upgrade to our Professional or Enterprise plans. There's no limit on the number of voters.</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-2xl border border-gold/10 overflow-hidden">
                    <button class="faq-toggle w-full px-6 py-5 text-left flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-dark">How do I get my earnings?</span>
                        <svg class="w-5 h-5 text-gold transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-muted">You can request a withdrawal from your dashboard at any time. Funds are typically processed within 24-48 hours to your registered bank account.</p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-white rounded-2xl border border-gold/10 overflow-hidden">
                    <button class="faq-toggle w-full px-6 py-5 text-left flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-dark">Can I customize the voting page with my branding?</span>
                        <svg class="w-5 h-5 text-gold transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="faq-content hidden px-6 pb-5">
                        <p class="text-muted">Yes! Professional and Enterprise plans include custom branding options. You can add your logo, choose colors, and customize the look and feel of your event pages.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function toggleFaq(button) {
        const content = button.nextElementSibling;
        const icon = button.querySelector('svg');
        
        // Close all other FAQs
        document.querySelectorAll('.faq-content').forEach(item => {
            if (item !== content) {
                item.classList.add('hidden');
                item.previousElementSibling.querySelector('svg').classList.remove('rotate-180');
            }
        });
        
        // Toggle current FAQ
        content.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }
</script>
@endpush