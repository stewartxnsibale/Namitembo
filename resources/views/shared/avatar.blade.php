@props(['user' => null, 'class' => ''])

@php
    $person = $user ?? auth()->user();
    $initials = collect(preg_split('/\s+/', trim($person?->name ?? 'NTC')))
        ->filter()
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->take(2)
        ->implode('');
@endphp

<span {{ $attributes->merge(['class' => 'avatar '.$class]) }}>
    @if ($person?->profile_photo_path)
        <img src="{{ Storage::disk('public')->url($person->profile_photo_path) }}" alt="">
    @else
        {{ $initials }}
    @endif
</span>
