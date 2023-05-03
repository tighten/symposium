@props([
    'href' => null,
    'icon' => null,
])

@php
    $element = isset($href) ? 'a' : 'button';
@endphp

<{{ $element }}
    @isset($href) href="{{ $href }}" @endisset
    {{ $attributes }}
>
    @svg($icon, 'fill-current inline w-5')
</{{ $element }}>
