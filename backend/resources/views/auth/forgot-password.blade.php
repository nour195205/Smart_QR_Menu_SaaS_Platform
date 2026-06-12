<x-guest-layout>
    <div style="text-align: center; margin-bottom: 24px;">
        <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0 0 8px 0; color: var(--text-primary);">Reset Password</h2>
        <p style="color: var(--text-secondary); margin: 0; font-size: 0.95rem; line-height: 1.5;">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="alert alert-success" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus />
            <x-input-error :messages="$errors->get('email')" style="color: var(--danger); margin-top: 8px; font-size: 0.875rem;" />
        </div>

        <div style="margin-top: 32px;">
            <button class="btn btn-primary" style="width: 100%;" type="submit">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>

        <div style="margin-top: 24px; text-align: center;">
            <a href="{{ route('login') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.9rem;">
                <i data-lucide="arrow-left" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"></i> 
                Back to log in
            </a>
        </div>
    </form>
</x-guest-layout>
