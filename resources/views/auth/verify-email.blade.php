<x-guest-layout>
    <div class="auth-form-head">
        <span class="eyebrow">One last step</span>
        <h1>Verify your email</h1>
        <p>We sent a verification link to your email address. Open it to activate your digital campus account.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="auth-status" role="status">A new verification link has been sent to your email address.</div>
    @endif

    <div class="auth-form">
        <div class="auth-note">
            <svg class="icon icon-sm"><use href="#icon-info"></use></svg>
            <span>If the email has not arrived, check your spam folder or request another link below.</span>
        </div>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-gold btn-lg btn-block">
                Resend verification email
                <svg class="icon"><use href="#icon-mail"></use></svg>
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline btn-block">Log out</button>
        </form>
    </div>
</x-guest-layout>
