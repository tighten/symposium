<x-panel size="md">
    <div class="bg-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                {{ $header }}
            </div>
            <div class="text-indigo-500 text-lg">
                {{ $actions }}
            </div>
        </div>
        @isset($body)
            <div class="mt-3 font-sans text-gray-500">
                {{ $body }}
            </div>
        @endisset
    </div>
    @isset($footer)
        <x-slot name="footer">
            {{ $footer }}
        </x-slot>
    @endisset
</x-panel>
