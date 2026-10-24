@extends('admin.layouts.app')

@section('title', 'Resource Library')
@section('page-kicker', 'Library')
@section('page-title', 'Resource library')

@section('content')
    <div class="page-head">
        <div>
            <div class="breadcrumb">
                <span>Admin</span>
                <svg class="icon"><use href="#icon-chevron-right"></use></svg>
                <span>Resource library</span>
            </div>
            <h1>Resource library</h1>
            <p>{{ number_format($totalMaterials) }} learning resources shared across all five departments.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">
                <svg class="icon icon-sm"><use href="#icon-grid"></use></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.materials.create') }}" class="btn btn-gold">
                <svg class="icon icon-sm"><use href="#icon-plus"></use></svg>
                Upload material
            </a>
        </div>
    </div>

    <form action="{{ route('admin.materials.index') }}" method="GET" class="toolbar">
        <div class="toolbar-group">
            <div class="toolbar-search">
                <svg class="icon"><use href="#icon-search"></use></svg>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search resources..." aria-label="Search resources">
            </div>
            <select name="department" aria-label="Filter by department">
                <option value="">All departments</option>
                @foreach (['ICT', 'FBW', 'CJ', 'TFD', 'BL'] as $department)
                    <option value="{{ $department }}" @selected(request('department') === $department)>{{ $department }} Department</option>
                @endforeach
            </select>
            @if (request()->filled('type'))
                <input type="hidden" name="type" value="{{ request('type') }}">
            @endif
        </div>
        <div class="toolbar-group">
            <div class="filter-pills">
                <a href="{{ route('admin.materials.index', array_filter(['search' => request('search'), 'department' => request('department')])) }}" class="filter-pill {{ ! request()->filled('type') ? 'active' : '' }}">All</a>
                @foreach (['pdf' => 'PDFs', 'video' => 'Videos', 'presentation' => 'Slides', 'image' => 'Images', 'document' => 'Documents'] as $type => $label)
                    <a href="{{ route('admin.materials.index', array_filter(['type' => $type, 'search' => request('search'), 'department' => request('department')])) }}" class="filter-pill {{ request('type') === $type ? 'active' : '' }}">{{ $label }}</a>
                @endforeach
            </div>
            <button type="submit" class="btn btn-outline btn-sm">
                <svg class="icon icon-sm"><use href="#icon-filter"></use></svg>
                Apply
            </button>
        </div>
    </form>

    @if ($materials->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><svg class="icon"><use href="#icon-library"></use></svg></div>
            <h3>No resources found</h3>
            <p>{{ request()->filled('search') || request()->filled('type') || request()->filled('department') ? 'Try adjusting your search or filters.' : 'Upload the first resource to start building the college library.' }}</p>
            @if (request()->filled('search') || request()->filled('type') || request()->filled('department'))
                <a href="{{ route('admin.materials.index') }}" class="btn btn-outline btn-sm">Clear filters</a>
            @else
                <a href="{{ route('admin.materials.create') }}" class="btn btn-gold btn-sm">Upload material</a>
            @endif
        </div>
    @else
        <div class="resource-grid">
            @foreach ($materials as $material)
                @php
                    $icon = match ($material->type) {
                        'video' => 'video',
                        'image' => 'image',
                        'presentation' => 'presentation',
                        'document' => 'file',
                        default => 'file',
                    };
                @endphp
                <article class="resource-card">
                    <div class="resource-cover cover-{{ $material->type }}">
                        <span class="resource-type">{{ $material->type }}</span>
                        <svg class="icon"><use href="#icon-{{ $icon }}"></use></svg>
                    </div>
                    <div class="resource-card-body">
                        <div class="resource-meta">
                            <span>{{ $material->department }} Department</span>
                            <span class="dot"></span>
                            <span>{{ $material->created_at->format('d M Y') }}</span>
                        </div>
                        <h3>{{ $material->title }}</h3>
                        <p>{{ $material->description }}</p>
                        <div class="resource-card-foot">
                            <span class="resource-date">{{ ucfirst($material->type) }}</span>
                            <button
                                type="button"
                                class="btn btn-navy btn-sm"
                                data-preview-url="{{ route('admin.materials.file', $material) }}"
                                data-preview-type="{{ $material->type }}"
                                data-preview-title="{{ $material->title }}"
                                data-preview-description="{{ \Illuminate\Support\Str::limit($material->description, 150) }}"
                                data-preview-open-url="{{ route('admin.materials.file', $material) }}"
                                data-preview-download-url="{{ route('admin.materials.file', $material) }}"
                            >
                                <svg class="icon icon-sm"><use href="#icon-eye"></use></svg>
                                Preview
                            </button>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        @if ($materials->hasPages())
            <div class="table-footer" style="padding:18px 0 0;border-top:0">
                <span>Showing {{ $materials->firstItem() }}–{{ $materials->lastItem() }} of {{ $materials->total() }} resources</span>
                <nav class="pagination" aria-label="Resource pages">
                    @if ($materials->onFirstPage())
                        <span class="disabled">Previous</span>
                    @else
                        <a href="{{ $materials->previousPageUrl() }}" rel="prev">Previous</a>
                    @endif

                    @foreach ($materials->getUrlRange(max(1, $materials->currentPage() - 2), min($materials->lastPage(), $materials->currentPage() + 2)) as $page => $url)
                        @if ($page == $materials->currentPage())
                            <span class="active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($materials->hasMorePages())
                        <a href="{{ $materials->nextPageUrl() }}" rel="next">Next</a>
                    @else
                        <span class="disabled">Next</span>
                    @endif
                </nav>
            </div>
        @endif
    @endif
@endsection
