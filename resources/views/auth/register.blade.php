<x-guest-layout>
    <div class="auth-form-head">
        <span class="eyebrow">Join the campus</span>
        <h1>Create your account</h1>
        <p>Set up your Namitembo digital campus profile in a few steps.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="form-field">
            <label for="name">Full name</label>
            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Your full name" required autofocus autocomplete="name">
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-field">
            <label for="email">Email address</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autocomplete="username">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-field">
                <label for="role">Account type</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="student" @selected(old('role', 'student') === 'student')>Student</option>
                    <option value="admin" @selected(old('role') === 'admin')>Administrator</option>
                </select>
                @error('role')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="department">Department</label>
                <select id="department" name="department" class="form-control" required>
                    <option value="ICT" @selected(old('department') === 'ICT')>ICT</option>
                    <option value="FBW" @selected(old('department') === 'FBW')>FBW</option>
                    <option value="CJ" @selected(old('department') === 'CJ')>CJ</option>
                    <option value="TFD" @selected(old('department') === 'TFD')>TFD</option>
                    <option value="BL" @selected(old('department') === 'BL')>BL</option>
                </select>
                @error('department')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-field">
            <label for="password">Password</label>
            <div style="position:relative">
                <input id="password" class="form-control" type="password" name="password" placeholder="At least 8 characters" required autocomplete="new-password" style="padding-right:48px">
                <button type="button" class="icon-btn" data-password-toggle="password" aria-label="Show password" style="position:absolute;top:50%;right:6px;width:36px;height:36px;transform:translateY(-50%)">
                    <svg class="icon icon-sm"><use href="#icon-eye"></use></svg>
                </button>
            </div>
            <p class="form-hint">Use a password with at least 8 characters.</p>
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-field">
            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="Repeat your password" required autocomplete="new-password">
            @error('password_confirmation')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-gold btn-lg btn-block">
            Create account
            <svg class="icon"><use href="#icon-arrow-right"></use></svg>
        </button>

        <div class="auth-note">
            <svg class="icon icon-sm"><use href="#icon-info"></use></svg>
            <span>Choose the department that matches your course. Your library is built around it.</span>
        </div>
    </form>

    <div class="auth-footer">
        Already registered? <a href="{{ route('login') }}">Log in instead</a>
    </div>
</x-guest-layout>
