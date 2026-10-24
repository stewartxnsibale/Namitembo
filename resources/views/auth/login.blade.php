<x-guest-layout>
    <div class="auth-form-head">
        <span class="eyebrow">Welcome back</span>
        <h1>Log in to your account</h1>
        <p>Continue to your library, dashboard and college resources.</p>
    </div>

    @if (session('status'))
        <div class="auth-status" role="status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="form-field">
            <label for="email">Email address</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus autocomplete="username">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-field">
            <label for="password">Password</label>
            <div style="position:relative">
                <input id="password" class="form-control" type="password" name="password" placeholder="Enter your password" required autocomplete="current-password" style="padding-right:48px">
                <button type="button" class="icon-btn" data-password-toggle="password" aria-label="Show password" style="position:absolute;top:50%;right:6px;width:36px;height:36px;transform:translateY(-50%)">
                    <svg class="icon icon-sm"><use href="#icon-eye"></use></svg>
                </button>
            </div>
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-options">
            <label class="checkbox" for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">
                Remember me
            </label>
            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn btn-gold btn-lg btn-block">
            Log in
            <svg class="icon"><use href="#icon-arrow-right"></use></svg>
        </button>

        <div class="auth-note">
            <svg class="icon icon-sm"><use href="#icon-shield"></use></svg>
            <span>Your account is protected. Use your college email and keep your password private.</span>
        </div>
    </form>

    <div class="auth-footer">
        New to the digital campus? <a href="{{ route('register') }}">Create an account</a>
    </div>
</x-guest-layout>
