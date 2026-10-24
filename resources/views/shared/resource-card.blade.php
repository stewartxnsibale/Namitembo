@props([
    'material',
    'fileRouteName',
    'detailRouteName' => null,
    'downloadRouteName' => null,
])

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
        <h3>
            @if ($detailRouteName)
                <a href="{{ route($detailRouteName, $material) }}">{{ $material->title }}</a>
            @else
                {{ $material->title }}
            @endif
        </h3>
        <p>{{ $material->description }}</p>
        <div class="resource-card-foot">
            <button
                type="button"
                class="btn btn-outline btn-sm"
                data-preview-url="{{ route($fileRouteName, $material) }}"
                data-preview-type="{{ $material->type }}"
                data-preview-title="{{ $material->title }}"
                data-preview-description="{{ \Illuminate\Support\Str::limit($material->description, 150) }}"
                data-preview-open-url="{{ route($fileRouteName, $material) }}"
                data-preview-download-url="{{ route($downloadRouteName ?? $fileRouteName, $material) }}"
            >
                <svg class="icon icon-sm"><use href="#icon-eye"></use></svg>
                Preview
            </button>
            @if ($detailRouteName)
                <a href="{{ route($detailRouteName, $material) }}" class="btn btn-navy btn-sm">
                    Open
                    <svg class="icon icon-sm"><use href="#icon-arrow-right"></use></svg>
                </a>
            @else
                <span class="resource-date">{{ ucfirst($material->type) }}</span>
            @endif
        </div>
    </div>
</article>
