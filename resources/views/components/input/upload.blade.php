@props([
    'name',
    'help',
])

<input
    name="{{ $name }}"
    type="file"
    {{ $attributes }}
>

@isset($help)
    <span class="block mt-1 text-gray-500">{{ $help }}</span>
@endisset
