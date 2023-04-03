<div
    {{ $attributes->except('v-text')->class('flex items-center') }}
>
    @if (isset($name) && isset($label))
        <label
            for="{{ $name }}"
            class="font-extrabold text-indigo-900 mr-2"
        >
            {{ $label }}
        </label>
    @endif

    <span
        class="p-2 border border-form-200 bg-indigo-300 rounded-l-md"
        {{ $attributes->only('v-text') }}
    ></span>
    <div class="flex-1">
        {{ $slot }}
    </div>
</div>
