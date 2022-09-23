@props([
    'name',
    'label',
    'help',
    'value' => null,
    'cols' => 50,
    'rows' => 10,
    'hideLabel' => false,
])

<div {{ $attributes->only(['class']) }}>
    <label
        for="{{ $name }}"
        class="block font-extrabold text-indigo-900 @if ($hideLabel) hidden @endif"
    >
        {{ $label }}
    </label>

    <textarea
        name="{{ $name }}"
        cols="{{ $cols }}"
        rows="{{ $rows }}"
        {{ $attributes->except('class') }}
        class="
            bg-white border-form-200 form-input placeholder-form-400 rounded w-full
            @unless ($hideLabel) mt-1 @endunless
        "
    >{{ old($name, $value) }}</textarea>

    @isset ($help)
        <span class="block mt-1 text-gray-500">{{ $help }}</span>
    @endisset
</div>
