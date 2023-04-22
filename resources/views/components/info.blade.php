@props([
    'icon' => null,
])

<span class="text-gray-500 text-sm flex">
    @if ($icon)
        @svg($icon, 'inline w-4 mr-1')
    @endif
    {{ $slot }}
</span>
