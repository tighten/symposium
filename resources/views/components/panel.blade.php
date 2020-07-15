@props([
    'size' => 'lg',
])

@php
    $styles = [
        'sm' => 'p-0',
        'md' => 'p-4',
        'lg' => 'p-10 max-w-md mx-auto sm:max-w-3xl',
    ];
@endphp

<div
    {{ $attributes->merge([
        'class' => "border-2 border-gray-300 bg-white rounded",
    ]) }}
>
    <div class="{{ $styles[$size] }}">
        {{ $slot }}
    </div>

    @isset ($body)
        {{ $body }}
    @endisset

    @isset ($footer)
        <div class="bg-indigo-150 py-3 font-sans flex justify-between {{ $styles[$size] }}">
            {{ $footer }}
        </div>
    @endisset
</div>

