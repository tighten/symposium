@props([
    'name',
    'label',
    'help',
    'value' => null,
    'type' => 'text',
    'inline' => false,
    'hideLabel' => false,
])

<div {{ $attributes->only(['class']) }}>
    <label
        for="{{ $name }}"
        class="font-bold text-indigo-500 @if ($hideLabel) hidden @endif"
    >
        {{ $label }}
    </label>

    <input
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->except('class') }}
        class="
            form-input
            @unless ($inline) w-full @endunless
            @unless ($hideLabel) mt-1 @endunless
        "
    >

    @isset ($help)
        <span class="block mt-1 text-gray-500">{{ $help }}</span>
    @endisset
</div>
