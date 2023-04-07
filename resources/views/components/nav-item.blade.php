@props([
    'route',
])

<a
    href="{{ route($route) }}"
    :class="{
        'block py-4': show,
        'hidden lg:block py-2': !show,
    }"
    class="px-3 rounded hover:underline
    @if (request()->isContainedBy($route)) bg-indigo-700 @endif"
>
    {{ $slot }}
</a>
