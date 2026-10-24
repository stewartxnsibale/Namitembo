@extends('admin.layouts.app')

@section('title', $material->title)
@section('page-kicker', 'Library')
@section('page-title', $material->title)

@section('content')
    <div class="page-head">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('admin.materials.index') }}">Resource library</a>
                <svg class="icon"><use href="#icon-chevron-right"></use></svg>
                <span>{{ \Illuminate\Support\Str::limit($material->title, 46) }}</span>
            </div>
            <h1>{{ $material->title }}</h1>
            <p>{{ $material->description }}</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.materials.edit', $material) }}" class="btn btn-outline">
                <svg class="icon icon-sm"><use href="#icon-edit"></use></svg>
                Edit
            </a>
            <form method="POST" action="{{ route('admin.materials.destroy', $material) }}" data-confirm="Delete {{ $material->title }}? This action cannot be undone.">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg class="icon icon-sm"><use href="#icon-trash"></use></svg>
                    Delete
                </button>
            </form>
            <a href="{{ route('admin.materials.index') }}" class="btn btn-navy">
                <svg class="icon icon-sm"><use href="#icon-arrow-left"></use></svg>
                Back
            </a>
        </div>
    </div>

    <div class="form-card">
        <div class="form-section" style="border-bottom:0;padding-bottom:0;margin-bottom:0">
            <div class="form-section-head">
                <h2>Resource information</h2>
                <p>Overview of this material.</p>
            </div>
            <div class="detail-list">
                <div class="detail-list-item">
                    <span>Title</span>
                    <strong>{{ $material->title }}</strong>
                </div>
                <div class="detail-list-item">
                    <span>Department</span>
                    <strong>{{ $material->department }}</strong>
                </div>
                <div class="detail-list-item">
                    <span>Type</span>
                    <strong>{{ ucfirst($material->type) }}</strong>
                </div>
                <div class="detail-list-item">
                    <span>Uploaded</span>
                    <strong>{{ $material->created_at->format('d M Y H:i') }}</strong>
                </div>
                <div class="detail-list-item">
                    <span>Last updated</span>
                    <strong>{{ $material->updated_at->format('d M Y H:i') }}</strong>
                </div>
            </div>
        </div>
    </div>
@endsection
