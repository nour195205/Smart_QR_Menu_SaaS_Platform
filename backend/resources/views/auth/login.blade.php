<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="alert alert-success" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="text-align: center; margin-bottom: 24px;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0 0 8px 0; color: var(--text-primary);">Welcome Back</h2>
            <p style="color: var(--text-secondary); margin: 0;">Log in to your account</p>
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" style="color: var(--danger); margin-top: 8px; font-size: 0.875rem;" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" style="color: var(--danger); margin-top: 8px; font-size: 0.875rem;" />
        </div>

        <!-- Remember Me -->
        <div class="form-group" style="display: flex; align-items: center; justify-content: space-between;">
            <label for="remember_me" style="display: inline-flex; align-items: center; cursor: pointer;">
                <input id="remember_me" type="checkbox" name="remember" style="margin-right: 8px; cursor: pointer;">
                <span style="color: var(--text-secondary); font-size: 0.9rem;">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a style="color: var(--accent-primary); text-decoration: none; font-size: 0.9rem;" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div style="margin-top: 32px;">
            <button class="btn btn-primary" style="width: 100%;" type="submit">
                {{ __('Log in') }}
            </button>
        </div>
        
        @if (Route::has('register'))
        <div style="margin-top: 24px; text-align: center;">
            <p style="color: var(--text-secondary); font-size: 0.9rem;">
                Don't have an account? 
                <a href="{{ route('register') }}" style="color: var(--accent-primary); text-decoration: none; font-weight: 500;">
                    Sign up
                </a>
            </p>
        </div>
        @endif
    </form>
</x-guest-layout>
