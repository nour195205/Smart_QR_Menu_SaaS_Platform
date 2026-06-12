<x-guest-layout>
    <div style="text-align: center; margin-bottom: 24px;">
        <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0 0 8px 0; color: var(--text-primary);">Create New Password</h2>
        <p style="color: var(--text-secondary); margin: 0; font-size: 0.95rem;">Please enter your new password below</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
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
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>
