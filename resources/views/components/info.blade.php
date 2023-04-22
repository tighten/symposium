@props([
    'icon' => null,
    'color' => 'text-gray-500'
])

<span {{ $attributes->merge([
    'class' => "{$color} text-sm flex items-center"
]) }}>
    @if ($icon)
        @svg($icon, 'inline fill-current w-4 mr-1')
    @endif
    {{ $slot }}
</span>
