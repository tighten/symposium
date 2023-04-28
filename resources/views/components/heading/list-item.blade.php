@props([
    'href',
])

<h3 class="font-semibold text-indigo-600">
    <a href="{{ $href }}">
        {{ $slot }}
    </a>
</h3>
