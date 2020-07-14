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
        'class' => 'bg-white border border-indigo-500 text-indigo-500'
    ])"
>
    {{ $slot }}
</x-button.base>
