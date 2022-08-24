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
            <div class="flex content-center justify-between pb-4">
                <div>
                    <h2 class="font-sans text-xl text-gray-500 uppercase">{{ $title }}</h2>

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

