<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="w-14 h-14 bg-gradient-to-br from-[#dab904]/20 to-[#bc893a]/20 rounded-2xl flex items-center justify-center mb-6">
            <svg class="w-7 h-7 text-[#bc893a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
        </div>
        <h2 class="text-2xl sm:text-3xl font-display font-bold text-gray-900 mb-2">
            Forgot your password?
        </h2>
        <p class="text-gray-600 leading-relaxed">
            No worries! Enter your email address and we'll send you a link to reset your password.
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="auth-success flex items-start gap-3">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-6">
            <label for="email" class="auth-label">Email Address</label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                class="auth-input @error('email') error @enderror" 
                placeholder="Enter your email address"
                required 
                autofocus
            >
            @error('email')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-btn-primary">
            Send Reset Link
        </button>
    </form>

    <!-- Back to Login -->
    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Sign In
        </a>
    </div>
</x-guest-layout>