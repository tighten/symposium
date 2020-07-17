@props([
    'size' => 'lg',
    'title',
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
        'class' => "shadow-md bg-white rounded",
    ]) }}
>
    <div class="{{ $styles[$size] }}">
        @isset ($title)
            <div class="pb-4 flex content-center justify-between">
                <div>
                    <h2 class="font-sans text-xl uppercase text-gray-500">{{ $title }}</h2>

                    @isset ($subtitle)
                        {{ $subtitle }}
                    @endisset
                </div>

                @isset ($actions)
                    {{ $actions }}
                @endisset
            </div>
        @endisset
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

