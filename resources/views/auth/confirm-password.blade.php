<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="w-14 h-14 bg-gradient-to-br from-[#dab904]/20 to-[#bc893a]/20 rounded-2xl flex items-center justify-center mb-6">
            <svg class="w-7 h-7 text-[#bc893a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
        </div>
        <h2 class="text-2xl sm:text-3xl font-display font-bold text-gray-900 mb-2">
            Confirm your password
        </h2>
        <p class="text-gray-600 leading-relaxed">
            This is a secure area. Please confirm your password before continuing.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-6">
            <label for="password" class="auth-label">Password</label>
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

        <!-- Submit Button -->
        <button type="submit" class="auth-btn-primary">
            Confirm Password
        </button>
    </form>

    <!-- Back Link -->
    <div class="mt-6 text-center">
        <a href="/" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Go Back
        </a>
    </div>
</x-guest-layout>