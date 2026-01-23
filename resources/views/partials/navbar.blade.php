<!-- Navigation -->
<nav class="fixed w-full bg-white/98 backdrop-blur-md z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 lg:h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('landing') }}" class="flex items-center space-x-1">
                    <!-- Logo Icon -->
                    <img src="{{ asset('images/voteafrika-logo.png') }}" alt="VoteAfrika Logo" class="h-10 w-10 sm:h-12 sm:w-12">
                    <!-- Logo Text -->
                    <span class="text-xl sm:text-2xl font-display font-bold text-gradient-gold">
                        VoteAfrika
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center justify-center flex-1 max-w-2xl mx-8">
                <div class="flex items-center space-x-12">
                    <a href="{{ route('landing') }}" class="nav-link-pro {{ request()->routeIs('landing') ? 'nav-link-pro-active' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('about') }}" class="nav-link-pro {{ request()->routeIs('about') ? 'nav-link-pro-active' : '' }}">
                        About
                    </a>
                    <a href="{{ route('home') }}" class="nav-link-pro {{ request()->routeIs('home') ? 'nav-link-pro-active' : '' }}">
                        Browse Events
                    </a>
                    <a href="{{ route('pricing') }}" class="nav-link-pro {{ request()->routeIs('pricing') ? 'nav-link-pro-active' : '' }}">
                        Pricing
                    </a>
                    <a href="{{ route('contact') }}" class="nav-link-pro {{ request()->routeIs('contact') ? 'nav-link-pro-active' : '' }}">
                        Contact
                    </a>
                </div>
            </div>

            <!-- Desktop Auth Buttons -->
            <div class="hidden lg:flex items-center space-x-4">
                @auth
                    <a href="{{ route('organizer.dashboard') }}" class="text-dark font-semibold hover:text-gold-dark transition-colors">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-muted font-medium hover:text-danger transition-colors">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-dark font-semibold hover:text-gold-dark transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary-sm">
                        Get Started
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden flex items-center">
                <button type="button" 
                        onclick="toggleMobileMenu()"
                        class="mobile-menu-btn p-2 rounded-lg text-dark hover:bg-gray-100 transition-colors"
                        aria-label="Toggle menu"
                        aria-expanded="false">
                    <!-- Hamburger Icon -->
                    <svg id="menu-icon-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <!-- Close Icon -->
                    <svg id="menu-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="lg:hidden hidden">
        <div class="bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <!-- Mobile Nav Links -->
                <div class="space-y-1">
                    <a href="{{ route('landing') }}" class="mobile-nav-link-pro {{ request()->routeIs('landing') ? 'mobile-nav-link-pro-active' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('about') }}" class="mobile-nav-link-pro {{ request()->routeIs('about') ? 'mobile-nav-link-pro-active' : '' }}">
                        About
                    </a>
                    <a href="{{ route('home') }}" class="mobile-nav-link-pro {{ request()->routeIs('home') ? 'mobile-nav-link-pro-active' : '' }}">
                        Browse Events
                    </a>
                    <a href="{{ route('pricing') }}" class="mobile-nav-link-pro {{ request()->routeIs('pricing') ? 'mobile-nav-link-pro-active' : '' }}">
                        Pricing
                    </a>
                    <a href="{{ route('contact') }}" class="mobile-nav-link-pro {{ request()->routeIs('contact') ? 'mobile-nav-link-pro-active' : '' }}">
                        Contact
                    </a>
                </div>

                <!-- Mobile Auth Section -->
                <div class="pt-4 mt-4 border-t border-gray-100">
                    @auth
                        <a href="{{ route('organizer.dashboard') }}" class="mobile-nav-link-pro">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" class="mobile-nav-link-pro w-full text-left text-danger">
                                Logout
                            </button>
                        </form>
                    @else
                        <div class="flex flex-col space-y-3">
                            <a href="{{ route('login') }}" class="mobile-nav-link-pro">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="btn-primary w-full text-center py-3">
                                Get Started Free
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu Script -->
<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const iconOpen = document.getElementById('menu-icon-open');
        const iconClose = document.getElementById('menu-icon-close');
        const menuBtn = document.querySelector('.mobile-menu-btn');
        
        const isOpen = !menu.classList.contains('hidden');
        
        if (isOpen) {
            menu.classList.add('hidden');
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
            menuBtn.setAttribute('aria-expanded', 'false');
        } else {
            menu.classList.remove('hidden');
            iconOpen.classList.add('hidden');
            iconClose.classList.remove('hidden');
            menuBtn.setAttribute('aria-expanded', 'true');
        }
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('mobile-menu');
        const menuBtn = document.querySelector('.mobile-menu-btn');
        
        if (menu && menuBtn && !menu.contains(event.target) && !menuBtn.contains(event.target)) {
            menu.classList.add('hidden');
            document.getElementById('menu-icon-open').classList.remove('hidden');
            document.getElementById('menu-icon-close').classList.add('hidden');
            menuBtn.setAttribute('aria-expanded', 'false');
        }
    });

    // Close mobile menu on window resize to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            const menu = document.getElementById('mobile-menu');
            if (menu) {
                menu.classList.add('hidden');
                document.getElementById('menu-icon-open').classList.remove('hidden');
                document.getElementById('menu-icon-close').classList.add('hidden');
            }
        }
    });
</script>