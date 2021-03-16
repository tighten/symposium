@props([
    'href' => null,
    'icon' => null,
    'size' => 'sm',
])

<x-button.base
    :href="$href"
    :icon="$icon"
    :size="$size"
    :attributes="$attributes->merge([
        'class' => 'bg-indigo-500 hover:bg-indigo-800 text-white'
    ])"
>
    {{ $slot }}
</x-button.base>
