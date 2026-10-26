@extends('admin.layouts.app')

@section('title', 'Edit Student')
@section('page-kicker', 'People')
@section('page-title', 'Edit student')

@section('content')
<div class="page-head">
    <div>
        <div class="breadcrumb">
            <a href="{{ route('admin.students.index') }}">Students</a>
            <svg class="icon">
                <use href="#icon-chevron-right"></use>
            </svg>
            <span>Edit account</span>
        </div>
        <h1>Edit student account</h1>
        <p>Update {{ $student->name }}'s details, department or password.</p>
    </div>
    <div class="page-actions">
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline">
            <svg class="icon icon-sm">
                <use href="#icon-arrow-left"></use>
            </svg>
            Back to students
        </a>
    </div>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.students.update', $student) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="form-section">
            <div class="row-between" style="align-items:flex-start;margin-bottom:22px">
                <div class="form-section-head" style="margin-bottom:0">
                    <h2>Student information</h2>
                    <p>These details are visible on the student's profile.</p>
                </div>
                <div class="table-user" style="gap:12px">
                    @include('shared.avatar', ['user' => $student, 'class' => 'avatar-lg'])
                    <div>
                        <strong style="display:block;color:var(--ntc-navy);font-size:13px">{{ $student->name }}</strong>
                        <span class="badge badge-gold" style="margin-top:5px">{{ $student->department }}</span>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-field">
                    <label for="name">Full name</label>
                    <input id="name" class="form-control" type="text" name="name"
                        value="{{ old('name', $student->name) }}" required autofocus autocomplete="name">
                    @error('name')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="email">Email address</label>
                    <input id="email" class="form-control" type="email" name="email"
                        value="{{ old('email', $student->email) }}" required autocomplete="email">
                    @error('email')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-row" style="margin-top:16px">
                <div class="form-field">
                    <label for="department">Department</label>
                    <select id="department" name="department" class="form-control" required>
                        @foreach ($departments as $department)
                        <option value="{{ $department }}" @selected(old('department', $student->department) ===
                            $department)>{{ $department }}</option>
                        @endforeach
                    </select>
                    @error('department')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label>Account status</label>
                    <div
                        style="display:flex;align-items:center;gap:9px;min-height:48px;padding:10px 14px;background:var(--ntc-pale);border-radius:11px">
                        <span class="badge badge-success">Active student</span>
                        <span class="muted" style="font-size:10px">Joined
                            {{ $student->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="form-field">
                    <label for="role">Role</label>
                    <select id="role" name="role" class="form-control" required>
                        <option value="">Select a role</option>
                        @foreach (['student', 'admin'] as $role)
                        <option value="{{ $role }}" @selected(old('role')===$role)>{{ $role }}</option>
                        @endforeach
                    </select>
                    @error('role')
                    <p class="form-hint" style="color:#c0392b">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-head">
                <h2>Profile photo</h2>
                <p>Upload a profile picture for this student. If none is uploaded, initials will be shown.</p>
            </div>

            <div class="form-row">
                <div class="form-field">
                    <label for="profile_photo">Profile photo</label>
                    <input id="profile_photo" class="form-control" type="file" name="profile_photo" accept="image/*">
                    @error('profile_photo')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="muted" style="font-size:10px;margin-top:6px">JPG, PNG, GIF, WEBP up to 2MB.</p>
                </div>
                @if ($student->profile_photo_path)
                <div class="form-field">
                    <label>Current photo</label>
                    <div
                        style="display:flex;align-items:center;gap:12px;min-height:48px;padding:10px 14px;background:var(--ntc-pale);border-radius:11px">
                        @include('shared.avatar', ['user' => $student, 'class' => 'avatar'])
                        <label style="display:flex;align-items:center;gap:8px;font-size:11px;color:var(--ntc-slate)">
                            <input type="checkbox" name="remove_profile_photo" value="1">
                            Remove current photo
                        </label>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-head">
                <h2>Reset password</h2>
                <p>Leave these fields blank to keep the student's current password.</p>
            </div>

            <div class="form-row">
                <div class="form-field">
                    <label for="password">New password</label>
                    <input id="password" class="form-control" type="password" name="password"
                        placeholder="Optional, minimum 8 characters" autocomplete="new-password">
                    @error('password')
                    <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="password_confirmation">Confirm new password</label>
                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation"
                        placeholder="Repeat the new password" autocomplete="new-password">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.students.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-gold">
                <svg class="icon icon-sm">
                    <use href="#icon-check"></use>
                </svg>
                Save changes
            </button>
        </div>
    </form>
</div>
@endsection