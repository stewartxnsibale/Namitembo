@extends('student.layouts.app')

@section('title', $material->title)
@section('page-kicker', 'My library')
@section('page-title', $material->title)

@section('content')
    @php
        $icon = match ($material->type) {
            'video' => 'video',
            'image' => 'image',
            'presentation' => 'presentation',
            'document' => 'file',
            default => 'file',
        };
        $extension = strtoupper(pathinfo($material->file_path, PATHINFO_EXTENSION));
    @endphp

    <div class="page-head">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('student.dashboard') }}">Dashboard</a>
                <svg class="icon"><use href="#icon-chevron-right"></use></svg>
                <a href="{{ route('student.library.index') }}">My library</a>
                <svg class="icon"><use href="#icon-chevron-right"></use></svg>
                <span>{{ \Illuminate\Support\Str::limit($material->title, 46) }}</span>
            </div>
            <h1>{{ $material->title }}</h1>
            <p>{{ $material->description }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('student.library.index') }}" class="btn btn-outline">
                <svg class="icon icon-sm"><use href="#icon-arrow-left"></use></svg>
                Back to library
            </a>
        </div>
    </div>

    <div class="detail-layout">
        <div>
            <div class="detail-preview">
                @if ($material->type === 'pdf')
                    <iframe src="{{ route('student.library.file', $material) }}" title="{{ $material->title }}"></iframe>
                @elseif ($material->type === 'video')
                    <video controls preload="metadata">
                        <source src="{{ route('student.library.file', $material) }}">
                        Your browser does not support embedded video playback.
                    </video>
                @elseif ($material->type === 'image')
                    <img src="{{ route('student.library.file', $material) }}" alt="{{ $material->title }}">
                @else
                    <div style="padding:50px 30px;text-align:center">
                        <svg class="icon"><use href="#icon-{{ $icon }}"></use></svg>
                        <h3 style="margin:18px 0 6px;color:var(--ntc-navy);font-size:15px;font-weight:800">{{ ucfirst($material->type) }} resource</h3>
                        <p style="max-width:320px;margin:0 auto 18px;color:var(--ntc-slate);font-size:11px;line-height:1.7">This file type cannot be previewed inside the browser. Open or download it to view the full resource.</p>
                        <a href="{{ route('student.library.file', $material) }}" target="_blank" rel="noopener" class="btn btn-navy btn-sm">
                            <svg class="icon icon-sm"><use href="#icon-external"></use></svg>
                            Open file
                        </a>
                    </div>
                @endif
            </div>

            <div class="detail-body">
                <span class="badge type-{{ $material->type }}">{{ $material->type }}</span>
                <h1>{{ $material->title }}</h1>
                <p>{{ $material->description }}</p>

                <div class="detail-meta">
                    <span>{{ $material->department }} Department</span>
                    <span>Uploaded {{ $material->created_at->format('d M Y') }}</span>
                    <span>{{ $extension }} file</span>
                </div>
            </div>
        </div>

        <aside class="detail-side" style="position:sticky;top:96px">
            <h2>Resource actions</h2>

            <button
                type="button"
                class="btn btn-gold"
                style="width:100%"
                data-preview-url="{{ route('student.library.file', $material) }}"
                data-preview-type="{{ $material->type }}"
                data-preview-title="{{ $material->title }}"
                data-preview-description="{{ \Illuminate\Support\Str::limit($material->description, 150) }}"
                data-preview-open-url="{{ route('student.library.file', $material) }}"
                data-preview-download-url="{{ route('student.library.download', $material) }}"
            >
                <svg class="icon icon-sm"><use href="#icon-eye"></use></svg>
                Preview resource
            </button>

            <a href="{{ route('student.library.download', $material) }}" class="btn btn-navy" style="width:100%">
                <svg class="icon icon-sm"><use href="#icon-download"></use></svg>
                Download file
            </a>

            <a href="{{ route('student.library.file', $material) }}" target="_blank" rel="noopener" class="btn btn-outline" style="width:100%">
                <svg class="icon icon-sm"><use href="#icon-external"></use></svg>
                Open in new tab
            </a>

            <div class="detail-list">
                <div class="detail-list-item">
                    <span>Department</span>
                    <strong>{{ $material->department }}</strong>
                </div>
                <div class="detail-list-item">
                    <span>Resource type</span>
                    <strong>{{ ucfirst($material->type) }}</strong>
                </div>
                <div class="detail-list-item">
                    <span>File format</span>
                    <strong>{{ $extension }}</strong>
                </div>
                <div class="detail-list-item">
                    <span>Uploaded</span>
                    <strong>{{ $material->created_at->format('d M Y') }}</strong>
                </div>
                <div class="detail-list-item">
                    <span>Last updated</span>
                    <strong>{{ $material->updated_at->format('d M Y') }}</strong>
                </div>
            </div>

            <div class="auth-note" style="margin-top:18px">
                <svg class="icon icon-sm"><use href="#icon-shield"></use></svg>
                <span>This resource is only available to {{ $material->department }} Department students.</span>
            </div>
        </aside>
    </div>
@endsection
