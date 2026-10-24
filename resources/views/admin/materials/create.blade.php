@extends('admin.layouts.app')

@section('title', 'Upload Material')
@section('page-kicker', 'Library')
@section('page-title', 'Upload material')

@section('content')
    <div class="page-head">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.materials.index') }}">Resource library</a>
                <svg class="icon"><use href="#icon-chevron-right"></use></svg>
                <span>Upload material</span>
            </div>
            <h1>Add a learning resource</h1>
            <p>Share notes, presentations, videos or images with the right department.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.materials.index') }}" class="btn btn-outline">
                <svg class="icon icon-sm"><use href="#icon-arrow-left"></use></svg>
                Back to library
            </a>
        </div>
    </div>

    <div class="profile-layout">
        <aside class="detail-side" style="position:sticky;top:96px">
            <div class="empty-icon" style="width:52px;height:52px;margin:0 0 16px">
                <svg class="icon"><use href="#icon-upload"></use></svg>
            </div>
            <h2 style="margin-bottom:8px">Upload guidance</h2>
            <p class="muted" style="font-size:11px;line-height:1.75">Give students a clear title and a short description so they can find the right resource quickly.</p>

            <div class="detail-list">
                <div class="detail-list-item">
                    <span>Documents</span>
                    <strong>PDF, DOC, DOCX</strong>
                </div>
                <div class="detail-list-item">
                    <span>Presentations</span>
                    <strong>PPT, PPTX</strong>
                </div>
                <div class="detail-list-item">
                    <span>Videos</span>
                    <strong>MP4, WebM</strong>
                </div>
                <div class="detail-list-item">
                    <span>Images</span>
                    <strong>JPG, PNG, WebP</strong>
                </div>
                <div class="detail-list-item">
                    <span>Maximum size</span>
                    <strong>100 MB</strong>
                </div>
            </div>

            <div class="auth-note" style="margin-top:18px">
                <svg class="icon icon-sm"><use href="#icon-shield"></use></svg>
                <span>Students only see resources from their own department.</span>
            </div>
        </aside>

        <div class="form-card" style="max-width:none">
            <form method="POST" action="{{ route('admin.materials.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-section">
                    <div class="form-section-head">
                        <h2>Resource details</h2>
                        <p>Tell students what this resource is and where it belongs.</p>
                    </div>

                    <div class="form-field">
                        <label for="title">Resource title</label>
                        <input id="title" class="form-control" type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Networking fundamentals — Module 04" required autofocus>
                        @error('title')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-row" style="margin-top:16px">
                        <div class="form-field">
                            <label for="department">Department</label>
                            <select id="department" name="department" class="form-control" required>
                                @foreach (['ICT', 'FBW', 'CJ', 'TFD', 'BL'] as $department)
                                    <option value="{{ $department }}" @selected(old('department') === $department)>{{ $department }} Department</option>
                                @endforeach
                            </select>
                            @error('department')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="type">Resource type</label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="pdf" @selected(old('type') === 'pdf')>PDF document</option>
                                <option value="presentation" @selected(old('type') === 'presentation')>Presentation</option>
                                <option value="document" @selected(old('type') === 'document')>Word document</option>
                                <option value="video" @selected(old('type') === 'video')>Video</option>
                                <option value="image" @selected(old('type') === 'image')>Image</option>
                            </select>
                            @error('type')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-field" style="margin-top:16px">
                        <label for="description">Description</label>
                        <textarea id="description" class="form-control" name="description" placeholder="A short summary of what students will learn from this resource..." required>{{ old('description') }}</textarea>
                        <p class="form-hint">Keep it clear and specific. Maximum 500 characters.</p>
                        @error('description')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-head">
                        <h2>Resource file</h2>
                        <p>Choose a file from your device. It will be available immediately after upload.</p>
                    </div>

                    <label class="file-drop" data-file-drop for="file">
                        <input id="file" type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.webm,.mov,.jpg,.jpeg,.png,.webp" required>
                        <span class="file-drop-icon"><svg class="icon icon-lg"><use href="#icon-upload"></use></svg></span>
                        <strong>Drop your file here, or click to browse</strong>
                        <span>PDF, Office document, video or image up to 100 MB</span>
                        <span class="file-name" data-file-name hidden></span>
                    </label>
                    @error('file')
                        <p class="form-error" style="margin-top:8px">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.materials.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-gold">
                        <svg class="icon icon-sm"><use href="#icon-upload"></use></svg>
                        Upload resource
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
