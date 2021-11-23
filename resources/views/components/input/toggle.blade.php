@props([
    'name',
    'label',
    'value' => null,
])

<div>
    <label for="{{ $name }}" class="text-xs text-gray-700">{{ $label }}</label>
    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
        <input type="hidden" name="{{ $name }}" value="0">
        <input
            type="checkbox"
            name="{{ $name }}"
            @if ((string) old($name, $value) === "1") checked @endif
            value="1"
            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer checked:right-0 checked:border-indigo-900"
        />
        <label
            for="{{ $name }}"
            class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"
        ></label>
    </div>
</div>
