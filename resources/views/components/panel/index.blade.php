@props([
    'size' => 'lg',
    'title',
])

@php
    $styles = [
        'sm' => 'p-0',
        'md' => 'p-0',
        'lg' => 'p-10 max-w-md mx-auto sm:max-w-3xl',
    ];
@endphp

<div
    {{ $attributes }}
>
    <div class="{{ $styles[$size] }}">
        @isset ($title)
            <div class="flex content-center justify-between pb-4">
                <div>
                    <h2 class="font-sans text-xl text-gray-900">
                        {{ $title }}
                    </h2>

                    @isset ($subtitle)
                        {{ $subtitle }}
                    @endisset
                </div>

                @isset ($actions)
                    {{ $actions }}
                @endisset
            </div>
        @endisset
    </div>

    <div class="bg-white rounded shadow">
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

