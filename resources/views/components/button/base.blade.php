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
        'class' => "py-2 rounded {$sizeClasses[$size]}"
    ]) }}
>
    <span class="flex items-center">
        @isset($icon)
            @svg($icon, 'fill-current hc-18 inline pr-1')
        @endisset
        {{ $slot }}
    </span>
</{{ $element }}>
