@extends('student.layouts.app')

@section('title', 'Dashboard')
@section('page-kicker', 'Student portal')
@section('page-title', 'Dashboard')

@section('content')
    @php
        $hour = now()->hour;
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
        $firstName = strtok(auth()->user()->name, ' ');
        $totalMaterials = $materialCounts->sum();
        $featured = $recentMaterials->first();
        $remaining = $featured ? $recentMaterials->slice(1) : $recentMaterials;
        $featuredIcon = $featured ? match ($featured->type) {
            'video' => 'video',
            'image' => 'image',
            'presentation' => 'presentation',
            default => 'file',
        } : 'library';
    @endphp

    <section class="student-welcome">
        <div class="student-welcome-copy">
            <span class="eyebrow">{{ now()->format('l, j F Y') }}</span>
            <h1>{{ $greeting }}, {{ $firstName }}.</h1>
            <p>Your {{ auth()->user()->department }} library is ready. Pick up where you left off or discover something new for your course.</p>
            <a href="{{ route('student.library.index') }}" class="btn btn-gold">
                Browse my library
                <svg class="icon"><use href="#icon-arrow-right"></use></svg>
            </a>
        </div>
        <div class="student-welcome-panel">
            <span>Your department</span>
            <strong>{{ auth()->user()->department }} Department</strong>
            <small>{{ number_format($totalMaterials) }} {{ \Illuminate\Support\Str::plural('resource', $totalMaterials) }} available to you</small>
            <div class="progress"><span style="--value:100%"></span></div>
        </div>
    </section>

    <div class="count-row">
        <div class="count-card count-pdf">
            <div class="count-card-icon"><svg class="icon"><use href="#icon-file"></use></svg></div>
            <div>
                <strong>{{ number_format($materialCounts->get('pdf', 0)) }}</strong>
                <span>PDF documents</span>
            </div>
        </div>
        <div class="count-card count-video">
            <div class="count-card-icon"><svg class="icon"><use href="#icon-video"></use></svg></div>
            <div>
                <strong>{{ number_format($materialCounts->get('video', 0)) }}</strong>
                <span>Video lessons</span>
            </div>
        </div>
        <div class="count-card count-presentation">
            <div class="count-card-icon"><svg class="icon"><use href="#icon-presentation"></use></svg></div>
            <div>
                <strong>{{ number_format($materialCounts->get('presentation', 0)) }}</strong>
                <span>Presentations</span>
            </div>
        </div>
        <div class="count-card count-image">
            <div class="count-card-icon"><svg class="icon"><use href="#icon-image"></use></svg></div>
            <div>
                <strong>{{ number_format($materialCounts->get('image', 0)) }}</strong>
                <span>Images and diagrams</span>
            </div>
        </div>
    </div>

    @if ($featured)
        <div class="material-list-label">
            Continue learning <span>·</span> Latest in your department
        </div>
        <article class="featured-resource" style="margin-bottom:26px">
            <div class="featured-cover">
                <svg class="icon"><use href="#icon-{{ $featuredIcon }}"></use></svg>
            </div>
            <div class="featured-body">
                <div class="resource-meta">
                    <span class="badge type-{{ $featured->type }}">{{ $featured->type }}</span>
                    <span>{{ $featured->created_at->format('d M Y') }}</span>
                </div>
                <h2>{{ $featured->title }}</h2>
                <p>{{ $featured->description }}</p>
                <div class="featured-actions">
                    <a href="{{ route('student.library.show', $featured) }}" class="btn btn-navy btn-sm">
                        Open resource
                        <svg class="icon icon-sm"><use href="#icon-arrow-right"></use></svg>
                    </a>
                    <button
                        type="button"
                        class="btn btn-outline btn-sm"
                        data-preview-url="{{ route('student.library.file', $featured) }}"
                        data-preview-type="{{ $featured->type }}"
                        data-preview-title="{{ $featured->title }}"
                        data-preview-description="{{ \Illuminate\Support\Str::limit($featured->description, 150) }}"
                        data-preview-open-url="{{ route('student.library.file', $featured) }}"
                        data-preview-download-url="{{ route('student.library.download', $featured) }}"
                    >
                        <svg class="icon icon-sm"><use href="#icon-eye"></use></svg>
                        Quick preview
                    </button>
                </div>
            </div>
        </article>
    @endif

    <div class="row-between" style="margin-bottom:14px">
        <div class="material-list-label" style="margin-bottom:0">Recently added</div>
        <a href="{{ route('student.library.index') }}" class="auth-link" style="font-size:10px">
            View entire library
            <svg class="icon icon-sm" style="display:inline;vertical-align:-2px"><use href="#icon-arrow-right"></use></svg>
        </a>
    </div>

    @if ($remaining->isEmpty())
        <div class="empty-state">
            <div class="empty-icon"><svg class="icon"><use href="#icon-library"></use></svg></div>
            <h3>{{ $featured ? 'That is everything for now' : 'Your library is waiting' }}</h3>
            <p>{{ $featured ? 'New resources will appear here as soon as your department uploads them.' : 'No resources have been added for your department yet. Check back soon.' }}</p>
            <a href="{{ route('student.library.index') }}" class="btn btn-outline btn-sm">Refresh library</a>
        </div>
    @else
        <div class="resource-grid">
            @foreach ($remaining as $material)
                @include('shared.resource-card', [
                    'material' => $material,
                    'fileRouteName' => 'student.library.file',
                    'detailRouteName' => 'student.library.show',
                    'downloadRouteName' => 'student.library.download',
                ])
            @endforeach
        </div>
    @endif
@endsection
