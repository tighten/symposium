@props([
    'name',
    'label' => null,
    'options' => [],
    'optionText' => '',
    'optionValue' => '',
    'hideLabel' => false,
    'inline' => false,
])

@php
    $classList = '';

    if ($inline) {
        $classList .=' flex items-center justify-between';
    }
@endphp

<div {{ $attributes->except('v-model')->class($classList) }}>
    <label
        for="currency"
        class="
            font-extrabold text-indigo-900
            @unless ($inline) block @endunless
        "
    >
        {{ $label }}
    </label>

    <div class="
        relative flex-1
        @if ($inline) ml-2 @endif
    ">
        <select
            name="{{ $name }}"
            {{ $attributes->only('v-model') }}
            class="
                border-form-200 form-input rounded w-full
                @unless ($hideLabel) mt-1 @endunless
            "
        >
            @foreach ($options as $option)
                <option value="{{ $option[$optionText] }}">
                    {{ $option[$optionValue] }}
                </option>
            @endforeach
        </select>
        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            @svg('dropdown')
        </span>
    </div>
</div>
