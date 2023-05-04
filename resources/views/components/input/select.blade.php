@props([
    'name',
    'label' => null,
    'labelClass' => 'font-extrabold text-indigo-900',
    'options' => [],
    'optionText' => '',
    'optionValue' => '',
    'hideLabel' => false,
    'inline' => false,
    'includeEmpty' => false,
    'inputClass' => '',
])

@php
    $classList = '';

    if ($inline) {
        $classList .=' flex items-center justify-between';
    }
@endphp

<div {{ $attributes->except(['v-model', 'wire:model'])->class($classList) }}>
    <label
        for="currency"
        class="
            {{ $labelClass }}
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
            {{ $attributes->only(['v-model', 'wire:model']) }}
            class="
                border-form-200 form-input rounded w-full
                @unless ($hideLabel) mt-1 @endunless
                {{ $inputClass }}
            "
        >
            @if ($includeEmpty)
                <option value=""></option>
            @endif
            @foreach ($options as $option)
                <option value="{{ $option[$optionValue] }}">
                    {{ $option[$optionText] }}
                </option>
            @endforeach
        </select>
        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            @svg('dropdown')
        </span>
    </div>
</div>
