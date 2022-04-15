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
        class="font-extrabold text-indigo-900 @if ($hideLabel) hidden @endif"
    >
        {{ $label }}
    </label>

    <input
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->except('class') }}
        class="
            bg-white border-form-200 placeholder-form-400 rounded
            @unless ($inline) w-full @endunless
            @unless ($hideLabel) mt-1 @endunless
        "
    >

    @isset ($help)
        <span class="block mt-1 text-gray-500">{{ $help }}</span>
    @endisset
</div>
