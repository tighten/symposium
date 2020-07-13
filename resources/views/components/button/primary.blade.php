@props([
    'href',
    'icon',
    'size' => 'sm',
])

@php
    $element = isset($href) ? 'a' : 'button';

    $sizeClasses = [
        'sm' => 'px-4',
        'md' => 'font-semibold px-8 text-lg',
    ];
@endphp

<{{ $element }}
    @isset($href) href="{{ $href }}" @endisset
    {{ $attributes->merge([
        'class' => "bg-indigo-500 py-2 rounded text-center text-white {$sizeClasses[$size]}"
    ]) }}
>
    @isset($icon)
        @svg($icon, 'w-3 h-3 fill-current inline mr-2')
    @endisset
    {{ $slot }}
</{{ $element }}>
