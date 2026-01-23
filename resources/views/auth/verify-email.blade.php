<x-guest-layout>
    <!-- Header -->
    <div class="mb-8 text-center">
        <div class="w-16 h-16 bg-gradient-to-br from-[#dab904]/20 to-[#bc893a]/20 rounded-full flex items-center justify-center mb-6 mx-auto">
            <svg class="w-8 h-8 text-[#bc893a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </div>
        <h2 class="text-2xl sm:text-3xl font-display font-bold text-gray-900 mb-2">
            Verify your email
        </h2>
        <p class="text-gray-600 leading-relaxed max-w-sm mx-auto">
            Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just sent you.
        </p>
    </div>

    <!-- Success Message -->
    @if (session('status') == 'verification-link-sent')
        <div class="auth-success flex items-start gap-3 mb-6">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>A new verification link has been sent to your email address.</span>
        </div>
    @endif

    <!-- Info Box -->
    <div class="bg-gray-50 rounded-xl p-5 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-gray-600 leading-relaxed">
                If you didn't receive the email, check your spam folder or click the button below to request another one.
            </p>
        </div>
    </div>

    <!-- Actions -->
    <div class="space-y-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="auth-btn-primary">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="auth-btn-secondary w-full">
                Sign Out
            </button>
        </form>
    </div>

    <!-- Help Text -->
    <div class="mt-8 text-center">
        <p class="text-sm text-gray-500">
            Need help? 
            <a href="/contact" class="auth-link">Contact Support</a>
        </p>
    </div>
</x-guest-layout>