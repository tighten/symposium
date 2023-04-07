@props([
    'route',
])

<a
    href="{{ route($route) }}"
    :class="show ? 'block py-4' : 'hidden lg:block py-2'"
    class="px-3 rounded hover:underline
    @if (request()->isContainedBy($route)) bg-indigo-700 @endif"
>
    {{ $slot }}
</a>
