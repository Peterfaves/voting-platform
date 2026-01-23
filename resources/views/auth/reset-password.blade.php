<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <div class="w-14 h-14 bg-gradient-to-br from-[#dab904]/20 to-[#bc893a]/20 rounded-2xl flex items-center justify-center mb-6">
            <svg class="w-7 h-7 text-[#bc893a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <h2 class="text-2xl sm:text-3xl font-display font-bold text-gray-900 mb-2">
            Reset your password
        </h2>
        <p class="text-gray-600 leading-relaxed">
            Create a new password for your account. Make sure it's strong and secure.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-5">
            <label for="email" class="auth-label">Email Address</label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email', $request->email) }}" 
                class="auth-input @error('email') error @enderror" 
                placeholder="Enter your email address"
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
            <label for="password" class="auth-label">New Password</label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                class="auth-input @error('password') error @enderror" 
                placeholder="Enter your new password"
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
            <label for="password_confirmation" class="auth-label">Confirm New Password</label>
            <input 
                id="password_confirmation" 
                type="password" 
                name="password_confirmation" 
                class="auth-input @error('password_confirmation') error @enderror" 
                placeholder="Confirm your new password"
                required 
                autocomplete="new-password"
            >
            @error('password_confirmation')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-btn-primary">
            Reset Password
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