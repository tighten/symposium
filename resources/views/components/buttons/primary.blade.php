@props([
    'href',
    'icon',
])

<a
    href="{{ $href }}"
    class="mt-4 w-full bg-indigo-500 text-white rounded px-4 py-2 block text-center"
>
    @svg($icon, 'w-3 h-3 fill-current inline mr-2')
    {{ $slot }}
</a>
