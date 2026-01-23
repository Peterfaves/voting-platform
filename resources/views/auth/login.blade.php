<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl sm:text-3xl font-display font-bold text-gray-900 mb-2">
            Welcome back
        </h2>
        <p class="text-gray-600">
            Sign in to your account to continue
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="auth-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-5">
            <label for="email" class="auth-label">Email Address</label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                class="auth-input @error('email') error @enderror" 
                placeholder="Enter your email"
                required 
                autofocus 
                autocomplete="username"
            >
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-5">
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="auth-label" style="margin-bottom: 0;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-link text-sm">
                        Forgot password?
                    </a>
                @else
                    <a href="/forgot-password" class="auth-link text-sm">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input 
                id="password" 
                type="password" 
                name="password" 
                class="auth-input @error('password') error @enderror" 
                placeholder="Enter your password"
                required 
                autocomplete="current-password"
            >
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="auth-checkbox" 
                    name="remember"
                >
                <span class="ml-2.5 text-sm text-gray-600">Remember me for 30 days</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-btn-primary">
            Sign In
        </button>
    </form>

    <!-- Register Link -->
    <p class="mt-6 text-center text-gray-600">
        Don't have an account? 
        <a href="{{ route('register') }}" class="auth-link">
            Create one now
        </a>
    </p>

    <!-- Divider -->
    <div class="auth-divider">
        <span>or</span>
    </div>

    <!-- Back to Home -->
    <a href="/" class="auth-btn-secondary flex items-center justify-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Home
    </a>
</x-guest-layout>