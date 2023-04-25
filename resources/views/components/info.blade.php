@props([
    'icon' => null,
    'iconColor' => 'text-gray-500',
    'textColor' => 'text-gray-500',
])

<span {{ $attributes->merge([
    'class' => "{$iconColor} text-sm flex items-center"
]) }}>
    @if ($icon)
        @svg($icon, 'inline fill-current w-4 mr-1')
    @endif
    <span class="{{ $textColor }}">
        {{ $slot }}
    </span>
</span>
