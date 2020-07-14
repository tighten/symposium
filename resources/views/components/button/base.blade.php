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
    <span class="flex items-center justify-center">
        @isset($icon)
            @svg($icon, 'w-3 h-3 fill-current inline mr-2')
        @endisset
        {{ $slot }}
    </span>
</{{ $element }}>
