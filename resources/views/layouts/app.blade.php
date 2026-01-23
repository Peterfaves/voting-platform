<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'VoteAfrika - The Ultimate Event Voting & Ticketing Platform.')">
    <meta name="author" content="VoteAfrika Media Services">
    
    <title>@yield('title', 'VoteAfrika - The Ultimate Event Voting & Ticketing Platform')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
    
    <!-- Navbar offset styles -->
    <style>
        .main-content-with-navbar-offset {
            padding-top: 80px !important;
            min-height: 100vh;
        }
        .main-content-no-offset {
            padding-top: 0 !important;
            min-height: 100vh;
        }
        @media (max-width: 1023px) {
            .main-content-with-navbar-offset {
                padding-top: 64px !important;
            }
        }
    </style>
</head>
<body class="bg-white font-body text-dark antialiased">
    
    <!-- NAVBAR -->
    @include('partials.navbar')

    <!-- FLASH MESSAGES -->
    @if(session('success'))
        <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-40 w-full max-w-lg px-4 alert-enter">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto">✕</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-40 w-full max-w-lg px-4 alert-enter">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto">✕</button>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-40 w-full max-w-lg px-4 alert-enter">
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('warning') }}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto">✕</button>
            </div>
        </div>
    @endif

    <!-- MAIN CONTENT -->
    @hasSection('no_padding')
        <main class="main-content-no-offset">
            @yield('content')
        </main>
    @else
        <main class="main-content-with-navbar-offset">
            @yield('content')
        </main>
    @endif

    <!-- FOOTER -->
    @include('partials.footer')

    <!-- Auto-dismiss flash messages -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.querySelectorAll('.alert-enter').forEach(function(alert) {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.3s ease';
                    setTimeout(function() { alert.remove(); }, 300);
                });
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>