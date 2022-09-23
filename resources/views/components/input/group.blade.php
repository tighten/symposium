<div
    {{ $attributes->except('v-text')->class('flex') }}
>
    <span
        class="p-2 bg-indigo-300 rounded-l-md"
        {{ $attributes->only('v-text') }}
    ></span>
    <div class="flex-1">
        {{ $slot }}
    </div>
</div>
