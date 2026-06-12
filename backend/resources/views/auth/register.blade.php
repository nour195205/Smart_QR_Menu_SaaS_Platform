<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="text-align: center; margin-bottom: 24px;">
            <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0 0 8px 0; color: var(--text-primary);">Create an Account</h2>
            <p style="color: var(--text-secondary); margin: 0;">Start building your smart menu</p>
        </div>

        <!-- Restaurant Name -->
        <div class="form-group">
            <label for="restaurant_name" class="form-label">{{ __('Restaurant Name') }}</label>
            <input id="restaurant_name" class="form-control" type="text" name="restaurant_name" value="{{ old('restaurant_name') }}" required autofocus autocomplete="organization" placeholder="e.g. Naa Cafe" />
            <x-input-error :messages="$errors->get('restaurant_name')" style="color: var(--danger); margin-top: 8px; font-size: 0.875rem;" />
        </div>

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">{{ __('Your Name') }}</label>
            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" style="color: var(--danger); margin-top: 8px; font-size: 0.875rem;" />
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" style="color: var(--danger); margin-top: 8px; font-size: 0.875rem;" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" style="color: var(--danger); margin-top: 8px; font-size: 0.875rem;" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" style="color: var(--danger); margin-top: 8px; font-size: 0.875rem;" />
        </div>

        <div style="margin-top: 32px;">
            <button class="btn btn-primary" style="width: 100%;" type="submit">
                {{ __('Register') }}
            </button>
        </div>

        <div style="margin-top: 24px; text-align: center;">
            <p style="color: var(--text-secondary); font-size: 0.9rem;">
                Already registered?
                <a href="{{ route('login') }}" style="color: var(--accent-primary); text-decoration: none; font-weight: 500;">
                    Log in
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
