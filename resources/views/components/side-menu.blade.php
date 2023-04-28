@props([
    'title',
    'links' => [],
    'defaults' => [],
])

@php
    $baseStyles = 'py-1 px-5 hover:bg-indigo-100';
@endphp

<x-panel size="sm" :padding="false" :attributes="$attributes->merge(['class' => 'flex-1 md:w-full font-sans'])">
    <div class="bg-indigo-150 p-5">{{ $title }}</div>
    <div class="flex flex-col py-4">
        @isset ($body)
            {{ $body }}
        @endisset

        @foreach ($links as $key => $link)
            @if (isset($link['query']))
                {!! HTML::activeLinkRoute(
                    $defaults,
                    $link['route'],
                    $link['label'],
                    $link['query'],
                    ['class' => $baseStyles]
                ) !!}
            @else
                <a
                    href="{{ route($link['route']) }}"
                    class="{{ $baseStyles }}"
                >
                    {{ $link['label'] }}
                </a>
            @endif
        @endforeach
    </div>
</x-panel>
