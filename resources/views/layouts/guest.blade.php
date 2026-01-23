<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VoteAfrika') }} - @yield('title', 'Authentication')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-display {
            font-family: 'Space Grotesk', sans-serif;
        }
        .text-gradient-gold {
            background: linear-gradient(135deg, #dab904 0%, #bc893a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .auth-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid #E5E7EB;
            border-radius: 0.75rem;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            background: #FFFFFF;
        }
        .auth-input:focus {
            outline: none;
            border-color: #dab904;
            box-shadow: 0 0 0 3px rgba(218, 185, 4, 0.1);
        }
        .auth-input::placeholder {
            color: #9CA3AF;
        }
        .auth-input.error {
            border-color: #DC2626;
        }
        .auth-input.error:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }
        .auth-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .auth-btn-primary {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background: linear-gradient(135deg, #dab904 0%, #bc893a 100%);
            color: #3A2E00;
            font-weight: 600;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            font-size: 0.9375rem;
        }
        .auth-btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }
        .auth-btn-primary:active {
            transform: translateY(0);
        }
        .auth-btn-secondary {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background: #FFFFFF;
            color: #374151;
            font-weight: 600;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            border: 1px solid #E5E7EB;
            cursor: pointer;
            font-size: 0.9375rem;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        .auth-btn-secondary:hover {
            border-color: #dab904;
            color: #bc893a;
        }
        .auth-link {
            color: #bc893a;
            font-weight: 500;
            transition: color 0.2s ease;
            text-decoration: none;
        }
        .auth-link:hover {
            color: #dab904;
            text-decoration: underline;
        }
        .auth-checkbox {
            width: 1.125rem;
            height: 1.125rem;
            border: 1.5px solid #D1D5DB;
            border-radius: 0.25rem;
            cursor: pointer;
            accent-color: #dab904;
        }
        .auth-checkbox:checked {
            background-color: #dab904;
            border-color: #dab904;
        }
        .auth-error {
            color: #DC2626;
            font-size: 0.8125rem;
            margin-top: 0.375rem;
        }
        .auth-success {
            background: rgba(22, 163, 74, 0.1);
            border: 1px solid rgba(22, 163, 74, 0.2);
            color: #16A34A;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }
        .auth-divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }
        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E5E7EB;
        }
        .auth-divider span {
            padding: 0 1rem;
            color: #9CA3AF;
            font-size: 0.8125rem;
            font-weight: 500;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[#4A3B00] to-[#3A2E00] relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <defs>
                        <pattern id="auth-grid" width="10" height="10" patternUnits="userSpaceOnUse">
                            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#auth-grid)" class="text-white"/>
                </svg>
            </div>
            
            <!-- Decorative Circles -->
            <div class="absolute -top-20 -left-20 w-80 h-80 bg-[#dab904] rounded-full opacity-10 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-20 w-96 h-96 bg-[#bc893a] rounded-full opacity-10 blur-3xl"></div>
            
            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center px-12 xl:px-20">
                <!-- Logo -->
                <a href="/" class="inline-block mb-12">
                    <span class="text-3xl xl:text-4xl font-display font-bold text-white">
                        Vote<span class="text-[#dab904]">Afrika</span>
                    </span>
                </a>
                
                <!-- Headline -->
                <h1 class="text-4xl xl:text-5xl font-display font-bold text-white leading-tight mb-6">
                    Transform Your Events with Powerful Voting
                </h1>
                <p class="text-lg text-white/70 leading-relaxed mb-10 max-w-md">
                    The all-in-one platform for event voting, ticketing, and audience engagement. Trusted by thousands of event organizers.
                </p>
                
                <!-- Stats -->
                <div class="flex gap-8">
                    <div>
                        <div class="text-3xl font-display font-bold text-[#dab904]">50K+</div>
                        <div class="text-white/60 text-sm font-medium">Active Users</div>
                    </div>
                    <div>
                        <div class="text-3xl font-display font-bold text-[#dab904]">1M+</div>
                        <div class="text-white/60 text-sm font-medium">Votes Cast</div>
                    </div>
                    <div>
                        <div class="text-3xl font-display font-bold text-[#dab904]">500+</div>
                        <div class="text-white/60 text-sm font-medium">Events</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-8 lg:p-12 bg-white">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <a href="/" class="inline-block">
                        <span class="text-2xl font-display font-bold text-gradient-gold">VoteAfrika</span>
                    </a>
                </div>
                
                {{ $slot }}
                
                <!-- Footer -->
                <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                    <p class="text-sm text-gray-500">
                        &copy; {{ date('Y') }} VoteAfrika. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>