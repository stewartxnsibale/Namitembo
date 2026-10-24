<x-guest-layout>
    <div class="auth-form-head">
        <span class="eyebrow">Choose a new password</span>
        <h1>Create a new password</h1>
        <p>Your new password should be unique and at least 8 characters long.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="auth-form">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-field">
            <label for="email">Email address</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-field">
            <label for="password">New password</label>
            <input id="password" class="form-control" type="password" name="password" placeholder="At least 8 characters" required autocomplete="new-password">
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-field">
            <label for="password_confirmation">Confirm new password</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="Repeat your new password" required autocomplete="new-password">
            @error('password_confirmation')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-gold btn-lg btn-block">
            Reset password
            <svg class="icon"><use href="#icon-lock"></use></svg>
        </button>
    </form>

    <div class="auth-footer">
        <a href="{{ route('login') }}">Return to login</a>
    </div>
</x-guest-layout>
