<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl sm:text-3xl font-display font-bold text-gray-900 mb-2">
            Create your account
        </h2>
        <p class="text-gray-600">
            Join thousands of event organizers on VoteAfrika
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-5">
            <label for="name" class="auth-label">Full Name</label>
            <input 
                id="name" 
                type="text" 
                name="name" 
                value="{{ old('name') }}" 
                class="auth-input @error('name') error @enderror" 
                placeholder="Enter your full name"
                required 
                autofocus 
                autocomplete="name"
            >
            @error('name')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

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
                autocomplete="username"
            >
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-5">
            <label for="password" class="auth-label">Password</label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                class="auth-input @error('password') error @enderror" 
                placeholder="Create a strong password"
                required 
                autocomplete="new-password"
            >
            @error('password')
                <p class="auth-error">{{ $message }}</p>
            @enderror
            <p class="text-xs text-gray-500 mt-2">Must be at least 8 characters</p>
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="auth-label">Confirm Password</label>
            <input 
                id="password_confirmation" 
                type="password" 
                name="password_confirmation" 
                class="auth-input @error('password_confirmation') error @enderror" 
                placeholder="Confirm your password"
                required 
                autocomplete="new-password"
            >
            @error('password_confirmation')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Terms Agreement -->
        <div class="mb-6">
            <label class="inline-flex items-start cursor-pointer">
                <input 
                    type="checkbox" 
                    class="auth-checkbox mt-0.5" 
                    name="terms"
                    required
                >
                <span class="ml-2.5 text-sm text-gray-600 leading-relaxed">
                    I agree to the 
                    <a href="/terms" class="auth-link">Terms of Service</a> 
                    and 
                    <a href="/privacy" class="auth-link">Privacy Policy</a>
                </span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-btn-primary">
            Create Account
        </button>
    </form>

    <!-- Login Link -->
    <p class="mt-6 text-center text-gray-600">
        Already have an account? 
        <a href="{{ route('login') }}" class="auth-link">
            Sign in
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