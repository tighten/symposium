@props([
    'url',
    'route',
    'show' => true,
])

@if ($show)
    @php
        $isActive = isset($url)
            ? request()->is(ltrim(parse_url($url, PHP_URL_PATH), '/'))
            : request()->isContainedBy($route);
    @endphp
    <a
        href="{{ $url ?? route($route) }}"
        :class="{
            'block py-4 lg:hidden': show,
            'hidden py-2': !show,
        }"
        class="px-3 rounded hover:underline
        @if ($isActive) bg-indigo-700 @endif"
    >
        {{ $slot }}
    </a>
@endif
