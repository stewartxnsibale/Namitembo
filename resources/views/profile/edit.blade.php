@extends(auth()->user()->role === 'admin' ? 'admin.layouts.app' : 'student.layouts.app')

@section('title', 'My Profile')
@section('page-kicker', 'Account')
@section('page-title', 'My profile')

@section('content')
    @php
        $user = auth()->user();
        $homeRoute = $user->role === 'admin' ? route('admin.dashboard') : route('student.dashboard');
    @endphp

    <div class="page-head">
        <div>
            <div class="breadcrumb">
                <a href="{{ $homeRoute }}">Dashboard</a>
                <svg class="icon"><use href="#icon-chevron-right"></use></svg>
                <span>My profile</span>
            </div>
            <h1>My profile</h1>
            <p>Manage your account details, password and account security.</p>
        </div>
        <div class="page-actions">
            <a href="{{ $homeRoute }}" class="btn btn-outline">
                <svg class="icon icon-sm"><use href="#icon-arrow-left"></use></svg>
                Back to dashboard
            </a>
        </div>
    </div>

    <div class="profile-layout">
        <aside class="profile-card">
            @include('shared.avatar', ['user' => $user, 'class' => 'avatar-lg'])
            <h2>{{ $user->name }}</h2>
            <p>{{ $user->email }}</p>
            <span class="badge badge-gold">{{ ucfirst($user->role) }} · {{ $user->department }}</span>

            <div class="profile-facts">
                <div class="profile-fact">
                    <span>Account type</span>
                    <strong>{{ ucfirst($user->role) }}</strong>
                </div>
                <div class="profile-fact">
                    <span>Department</span>
                    <strong>{{ $user->department }}</strong>
                </div>
                <div class="profile-fact">
                    <span>Joined</span>
                    <strong>{{ $user->created_at->format('M Y') }}</strong>
                </div>
                <div class="profile-fact">
                    <span>Email status</span>
                    <strong>{{ $user->email_verified_at ? 'Verified' : 'Pending' }}</strong>
                </div>
            </div>
        </aside>

        <div class="form-card" style="max-width:none">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-section">
                    <div class="form-section-head">
                        <h2>Account details</h2>
                        <p>Update the name and email address attached to your account.</p>
                    </div>

                    <div class="form-field">
                        <label for="name">Full name</label>
                        <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field" style="margin-top:16px">
                        <label for="email">Email address</label>
                        <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-gold">
                            <svg class="icon icon-sm"><use href="#icon-check"></use></svg>
                            Save details
                        </button>
                    </div>
                </div>
            </form>

            <form method="POST" action="{{ route('password.update') }}" style="margin-top:26px;padding-top:26px;border-top:1px solid var(--ntc-line)">
                @csrf
                @method('PUT')

                <div class="form-section" style="border-bottom:0;padding-bottom:0;margin-bottom:0">
                    <div class="form-section-head">
                        <h2>Change password</h2>
                        <p>Use a strong password that you do not use on any other site.</p>
                    </div>

                    @if ($errors->updatePassword->any())
                        <div class="auth-note" style="margin-bottom:16px">
                            <svg class="icon icon-sm"><use href="#icon-info"></use></svg>
                            <span>Please check the password fields below.</span>
                        </div>
                    @endif

                    <div class="form-field">
                        <label for="current_password">Current password</label>
                        <div style="position:relative">
                            <input id="current_password" class="form-control" type="password" name="current_password" required autocomplete="current-password" style="padding-right:48px">
                            <button type="button" class="icon-btn" data-password-toggle="current_password" aria-label="Show current password" style="position:absolute;top:50%;right:6px;width:36px;height:36px;transform:translateY(-50%)">
                                <svg class="icon icon-sm"><use href="#icon-eye"></use></svg>
                            </button>
                        </div>
                        @error('current_password', 'updatePassword')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-row" style="margin-top:16px">
                        <div class="form-field">
                            <label for="new_password">New password</label>
                            <div style="position:relative">
                                <input id="new_password" class="form-control" type="password" name="password" required autocomplete="new-password" style="padding-right:48px">
                                <button type="button" class="icon-btn" data-password-toggle="new_password" aria-label="Show new password" style="position:absolute;top:50%;right:6px;width:36px;height:36px;transform:translateY(-50%)">
                                    <svg class="icon icon-sm"><use href="#icon-eye"></use></svg>
                                </button>
                            </div>
                            @error('password', 'updatePassword')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="password_confirmation">Confirm new password</label>
                            <div style="position:relative">
                                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" style="padding-right:48px">
                                <button type="button" class="icon-btn" data-password-toggle="password_confirmation" aria-label="Show confirmed password" style="position:absolute;top:50%;right:6px;width:36px;height:36px;transform:translateY(-50%)">
                                    <svg class="icon icon-sm"><use href="#icon-eye"></use></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-navy">
                            <svg class="icon icon-sm"><use href="#icon-lock"></use></svg>
                            Update password
                        </button>
                    </div>
                </div>
            </form>

            <div style="margin-top:26px;padding-top:26px;border-top:1px solid var(--ntc-line)">
                <div class="form-section-head">
                    <h2 style="color:#a13a32">Delete account</h2>
                    <p>Once deleted, your account and all associated data will be permanently removed.</p>
                </div>

                @if ($errors->userDeletion->any())
                    <p class="form-error" style="margin-bottom:12px">{{ $errors->userDeletion->first() }}</p>
                @endif

                <form method="POST" action="{{ route('profile.destroy') }}" data-confirm="Are you sure you want to delete your account? This cannot be undone.">
                    @csrf
                    @method('DELETE')

                    <div class="form-row">
                        <div class="form-field">
                            <label for="delete_password">Confirm your password</label>
                            <input id="delete_password" class="form-control" type="password" name="password" placeholder="Enter your password to continue" required autocomplete="current-password">
                        </div>
                        <div class="form-field" style="display:flex;align-items:flex-end">
                            <button type="submit" class="btn btn-danger" style="width:100%">
                                <svg class="icon icon-sm"><use href="#icon-trash"></use></svg>
                                Delete my account
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
