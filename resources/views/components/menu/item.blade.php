@props([
    'url' => null,
    'route' => null,
    'show' => true,
])

@if ($show)
    <a
        class="px-4 py-1 hover:bg-indigo-600 hover:text-white whitespace-nowrap"
        href="{{ $url ?? route($route) }}"
    >
        {{ $slot }}
    </a>
@endif
