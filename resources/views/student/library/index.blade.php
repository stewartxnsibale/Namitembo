@extends('student.layouts.app')

@section('title', 'My Library')
@section('page-kicker', 'Learning')
@section('page-title', 'My library')

@section('content')
    @php
        $totalMaterials = $materialCounts->sum();
    @endphp

    <div class="page-head">
        <div>
            <div class="breadcrumb">
                <a href="{{ route('student.dashboard') }}">Dashboard</a>
                <svg class="icon"><use href="#icon-chevron-right"></use></svg>
                <span>My library</span>
            </div>
            <h1>My library</h1>
            <p>{{ number_format($totalMaterials) }} resources curated for the {{ auth()->user()->department }} Department.</p>
        </div>
        <div class="page-actions">
            <a href="{{ route('student.dashboard') }}" class="btn btn-outline">
                <svg class="icon icon-sm"><use href="#icon-grid"></use></svg>
                Dashboard
            </a>
            <a href="{{ route('student.profile') }}" class="btn btn-gold">
                <svg class="icon icon-sm"><use href="#icon-user"></use></svg>
                My profile
            </a>
        </div>
    </div>

    <div class="toolbar">
        <div class="toolbar-group">
            <form action="{{ route('student.library.index') }}" method="GET" style="display:flex;flex-wrap:wrap;gap:8px;align-items:center">
                @if (request()->filled('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                <div class="toolbar-search">
                    <svg class="icon"><use href="#icon-search"></use></svg>
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search titles and descriptions..." aria-label="Search the library">
                </div>
                <button type="submit" class="btn btn-outline btn-sm">Search</button>
            </form>
        </div>
        <div class="filter-pills">
            <a href="{{ route('student.library.index', array_filter(['search' => request('search')])) }}" class="filter-pill {{ ! request()->filled('type') ? 'active' : '' }}">All</a>
            @foreach (['pdf' => 'PDFs', 'video' => 'Videos', 'presentation' => 'Slides', 'image' => 'Images', 'document' => 'Documents'] as $type => $label)
                <a href="{{ route('student.library.index', array_filter(['type' => $type, 'search' => request('search')])) }}" class="filter-pill {{ request('type') === $type ? 'active' : '' }}">{{ $label }}</a>
            @endforeach
        </div>
    </div>

    <div class="row-between" style="margin-bottom:14px">
        <span class="material-list-label" style="margin:0">
            @if (request()->filled('search') || request()->filled('type'))
                Showing {{ $materials->total() }} filtered {{ \Illuminate\Support\Str::plural('resource', $materials->total()) }}
            @else
                All department resources
            @endif
        </span>
        @if (request()->filled('search') || request()->filled('type'))
            <a href="{{ route('student.library.index') }}" class="btn btn-ghost btn-sm">Clear filters</a>
        @endif
    </div>

    @if ($materials->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><svg class="icon"><use href="#icon-library"></use></svg></div>
            <h3>No resources found</h3>
            <p>{{ request()->filled('search') || request()->filled('type') ? 'Try a different search term or choose another resource type.' : 'Your department has not uploaded any resources yet. Check back soon.' }}</p>
            @if (request()->filled('search') || request()->filled('type'))
                <a href="{{ route('student.library.index') }}" class="btn btn-outline btn-sm">Clear filters</a>
            @endif
        </div>
    @else
        <div class="resource-grid">
            @foreach ($materials as $material)
                @include('shared.resource-card', [
                    'material' => $material,
                    'fileRouteName' => 'student.library.file',
                    'detailRouteName' => 'student.library.show',
                    'downloadRouteName' => 'student.library.download',
                ])
            @endforeach
        </div>

        @if ($materials->hasPages())
            <div class="table-footer" style="padding:20px 0 0;border-top:0">
                <span>Showing {{ $materials->firstItem() }}–{{ $materials->lastItem() }} of {{ $materials->total() }} resources</span>
                <nav class="pagination" aria-label="Library pages">
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
