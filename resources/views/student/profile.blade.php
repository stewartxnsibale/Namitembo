@extends('student.layouts.app')

@section('title', 'My Profile')
@section('page-kicker', 'Account')
@section('page-title', 'My profile')

@section('content')
    <div class="page-head">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('student.dashboard') }}">Dashboard</a>
                <svg class="icon"><use href="#icon-chevron-right"></use></svg>
                <span>My profile</span>
            </div>
            <h1>My profile</h1>
            <p>Keep your account details current so your library stays relevant to your course.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('student.dashboard') }}" class="btn btn-outline">
                <svg class="icon icon-sm"><use href="#icon-arrow-left"></use></svg>
                Back to dashboard
            </a>
        </div>
    </div>

    <div class="profile-layout">
        <aside class="profile-card">
            @include('shared.avatar', ['user' => $student, 'class' => 'avatar-lg'])
            <h2>{{ $student->name }}</h2>
            <p>{{ $student->email }}</p>

            <span class="badge dept-{{ strtolower($student->department) }}">{{ $student->department }} Department</span>

            <div class="profile-facts">
                <div class="profile-fact">
                    <span>Account type</span>
                    <strong>{{ ucfirst($student->role) }}</strong>
                </div>
                <div class="profile-fact">
                    <span>Department</span>
                    <strong>{{ $student->department }}</strong>
                </div>
                <div class="profile-fact">
                    <span>Joined</span>
                    <strong>{{ $student->created_at->format('M Y') }}</strong>
                </div>
                <div class="profile-fact">
                    <span>Email status</span>
                    <strong>{{ $student->email_verified_at ? 'Verified' : 'Pending' }}</strong>
                </div>
            </div>
        </aside>

        <div class="form-card" style="max-width:none">
            <form method="POST" action="{{ route('student.profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="form-section">
                    <div class="form-section-head">
                        <h2>Account details</h2>
                        <p>Update your name, email address and department.</p>
                    </div>

                    <div class="form-field">
                        <label for="name">Full name</label>
                        <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $student->name) }}" required autocomplete="name">
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-row" style="margin-top:16px">
                        <div class="form-field">
                            <label for="email">Email address</label>
                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $student->email) }}" required autocomplete="username">
                            @error('email')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="department">Department</label>
                            <select id="department" name="department" class="form-control" required>
                                @foreach ($departments as $department)
                                    <option value="{{ $department }}" @selected(old('department', $student->department) === $department)>{{ $department }} Department</option>
                                @endforeach
                            </select>
                            @error('department')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if ($student->email_verified_at === null)
                        <div class="auth-note" style="margin-top:16px">
                            <svg class="icon icon-sm"><use href="#icon-mail"></use></svg>
                            <span>Changing your email address will require verification before it can be used.</span>
                        </div>
                    @endif
                </div>

                <div class="form-section">
                    <div class="form-section-head">
                        <h2>Change password</h2>
                        <p>Leave these fields blank if you do not want to change your password.</p>
                    </div>

                    <div class="form-field">
                        <label for="current_password">Current password</label>
                        <div style="position:relative">
                            <input id="current_password" class="form-control" type="password" name="current_password" placeholder="Enter your current password" autocomplete="current-password" style="padding-right:48px">
                            <button type="button" class="icon-btn" data-password-toggle="current_password" aria-label="Show current password" style="position:absolute;top:50%;right:6px;width:36px;height:36px;transform:translateY(-50%)">
                                <svg class="icon icon-sm"><use href="#icon-eye"></use></svg>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-row" style="margin-top:16px">
                        <div class="form-field">
                            <label for="password">New password</label>
                            <div style="position:relative">
                                <input id="password" class="form-control" type="password" name="password" placeholder="At least 8 characters" autocomplete="new-password" style="padding-right:48px">
                                <button type="button" class="icon-btn" data-password-toggle="password" aria-label="Show new password" style="position:absolute;top:50%;right:6px;width:36px;height:36px;transform:translateY(-50%)">
                                    <svg class="icon icon-sm"><use href="#icon-eye"></use></svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="password_confirmation">Confirm new password</label>
                            <div style="position:relative">
                                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="Repeat the new password" autocomplete="new-password" style="padding-right:48px">
                                <button type="button" class="icon-btn" data-password-toggle="password_confirmation" aria-label="Show confirmed password" style="position:absolute;top:50%;right:6px;width:36px;height:36px;transform:translateY(-50%)">
                                    <svg class="icon icon-sm"><use href="#icon-eye"></use></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('student.dashboard') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-gold">
                        <svg class="icon icon-sm"><use href="#icon-check"></use></svg>
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
