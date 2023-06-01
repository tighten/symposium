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
        'class' => 'bg-white border border-gray-300 text-gray-500'
    ])"
>
    {{ $slot }}
</x-button.base>
