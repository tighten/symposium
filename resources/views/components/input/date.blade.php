@props([
    'name',
    'label',
    'value' => null,
])

<x-input.text
    name="{{ $name }}"
    label="{{ $label }}"
    value="{{ $value }}"
    type="date"
    :attributes="$attributes->merge([
        'id' => $name
    ])"
></x-input.text>
