<div
    {{ $attributes->merge([
        'class' => 'border-2 border-gray-300 bg-white rounded',
    ]) }}
>
    {{ $slot }}
</div>
