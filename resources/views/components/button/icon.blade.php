@props([
    'href' => null,
    'icon' => null,
])

@php
    $element = isset($href) ? 'a' : 'button';
@endphp

<{{ $element }}
    @isset($href) href="{{ $href }}" @endisset
    {{ $attributes->class('leading-none') }}
>
    @svg($icon, 'fill-current inline w-5')
</{{ $element }}>
