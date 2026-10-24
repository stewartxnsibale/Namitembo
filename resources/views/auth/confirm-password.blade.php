<x-guest-layout>
    <div class="auth-form-head">
        <span class="eyebrow">Secure area</span>
        <h1>Confirm your password</h1>
        <p>Please confirm your password before continuing to this protected area.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf

        <div class="form-field">
            <label for="password">Password</label>
            <input id="password" class="form-control" type="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-gold btn-lg btn-block">
            Confirm and continue
            <svg class="icon"><use href="#icon-arrow-right"></use></svg>
        </button>
    </form>
</x-guest-layout>
