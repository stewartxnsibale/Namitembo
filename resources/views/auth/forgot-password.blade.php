<x-guest-layout>
    <div class="auth-form-head">
        <span class="eyebrow">Account recovery</span>
        <h1>Reset your password</h1>
        <p>Enter your email address and we will send you a secure link to choose a new password.</p>
    </div>

    @if (session('status'))
        <div class="auth-status" role="status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <div class="form-field">
            <label for="email">Email address</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus autocomplete="username">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-gold btn-lg btn-block">
            Send reset link
            <svg class="icon"><use href="#icon-mail"></use></svg>
        </button>
    </form>

    <div class="auth-footer">
        Remembered it? <a href="{{ route('login') }}">Back to login</a>
    </div>
</x-guest-layout>
