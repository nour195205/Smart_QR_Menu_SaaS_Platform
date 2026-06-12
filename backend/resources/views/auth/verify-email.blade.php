<x-guest-layout>
    <div style="text-align: center; margin-bottom: 24px;">
        <h2 style="font-size: 1.5rem; font-weight: 600; margin: 0 0 8px 0; color: var(--text-primary);">Verify Your Email</h2>
        <p style="color: var(--text-secondary); margin: 0; font-size: 0.95rem; line-height: 1.5;">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 32px;">
        <form method="POST" action="{{ route('verification.send') }}" style="margin: 0;">
            @csrf
            <button class="btn btn-primary" type="submit">
                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="btn btn-secondary">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
