@props([
    'name',
    'label',
    'value' => null,
])

<v-date-picker
    class="inline-block h-full"
    value="{{ $value }}"
    timezone="UTC"
    {{ $attributes->only('v-model') }}
>
    <template v-slot="{ inputValue, inputEvents, togglePopover }">
        <x-input.text
            name="{{ $name }}"
            label="{{ $label }}"
            :attributes="$attributes->except('v-model')->merge([
                'id' => $name
            ])"
            v-model="inputValue"
            v-on="inputEvents"
        ></x-input.text>
    </template>
</v-date-picker>
