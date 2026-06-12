<x-guest-layout>
    <div style="text-align: center; margin-bottom: 24px;">
        <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0 0 8px 0; color: var(--text-primary);">Confirm Password</h2>
        <p style="color: var(--text-secondary); margin: 0; font-size: 0.95rem;">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" style="color: var(--danger); margin-top: 8px; font-size: 0.875rem;" />
        </div>

        <div style="margin-top: 32px;">
            <button class="btn btn-primary" style="width: 100%;" type="submit">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>
