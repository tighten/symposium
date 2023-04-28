<span
    {{ $attributes->merge([
        'class' => 'font-medium leading-4 rounded-lg text-xs whitespace-nowrap',
        'style' => 'padding: 2px 10px;'
    ]) }}
>
    {{ $slot }}
</span>
