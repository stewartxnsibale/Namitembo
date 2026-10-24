@extends('admin.layouts.app')

@section('title', 'Edit Resource')
@section('page-kicker', 'Library')
@section('page-title', 'Edit resource')

@section('content')
    <div class="page-head">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.materials.index') }}">Resource library</a>
                <svg class="icon"><use href="#icon-chevron-right"></use></svg>
                <span>Edit resource</span>
            </div>
            <h1>Edit resource</h1>
            <p>Update details or replace the uploaded file.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.materials.index') }}" class="btn btn-outline">
                <svg class="icon icon-sm"><use href="#icon-arrow-left"></use></svg>
                Back to library
            </a>
        </div>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.materials.update', $material) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="form-section">
                <div class="form-section-head">
                    <h2>Resource details</h2>
                    <p>Give clear information so students can find it easily.</p>
                </div>

                <div class="form-field">
                    <label for="title">Title</label>
                    <input id="title" class="form-control" type="text" name="title" value="{{ old('title', $material->title) }}" required>
                    @error('title')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-row" style="margin-top:16px">
                    <div class="form-field">
                        <label for="department">Department</label>
                        <select id="department" name="department" class="form-control" required>
                            @foreach (['ICT', 'FBW', 'BL', 'CJ', 'TFD'] as $department)
                                <option value="{{ $department }}" @selected(old('department', $material->department) === $department)>{{ $department }} Department</option>
                            @endforeach
                        </select>
                        @error('department')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="type">Resource type</label>
                        <select id="type" name="type" class="form-control" required>
                            @foreach (['pdf' => 'PDF', 'video' => 'Video', 'presentation' => 'Presentation', 'document' => 'Document', 'image' => 'Image'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('type', $material->type) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-field" style="margin-top:16px">
                    <label for="description">Description</label>
                    <textarea id="description" class="form-control" name="description" rows="4" required>{{ old('description', $material->description) }}</textarea>
                    @error('description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-head">
                    <h2>File</h2>
                    <p>Leave empty to keep the current file. Upload a new file to replace it.</p>
                </div>

                <div class="form-field">
                    <label for="file">Replace file (optional)</label>
                    <input id="file" class="form-control" type="file" name="file">
                    @error('file')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                    <p class="muted" style="font-size:10px;margin-top:6px">Maximum size 100MB.</p>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.materials.index') }}" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-gold">
                    <svg class="icon icon-sm"><use href="#icon-check"></use></svg>
                    Save changes
                </button>
            </div>
        </form>
    </div>
@endsection
