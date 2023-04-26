@props([
    'href',
    'icon',
    'size' => 'sm',
])

@php
    $element = isset($href) ? 'a' : 'button';
@endphp

<{{ $element }}
    @isset($href) href="{{ $href }}" @endisset
    {{ $attributes->class([
        "py-2 rounded inline-flex items-center justify-center space-x-2",
        'px-2' => $size === 'sm' && $slot->isEmpty(),
        'px-4' => $size === 'sm' && $slot->isNotEmpty(),
        'font-semibold px-8 text-lg' => $size === 'md',
    ]) }}
>
    @isset($icon)
        @svg($icon, 'w-3 h-3 fill-current inline')
    @endisset
    @if ($slot->isNotEmpty())
        <span>{{ $slot }}</span>
    @endif
</{{ $element }}>
