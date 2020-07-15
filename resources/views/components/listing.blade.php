<x-panel class="mt-4 hover:border-indigo">
    <div class="bg-white p-4">
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
        <div class="bg-indigo-150 p-4 font-sans flex justify-between">
            {{ $footer }}
        </div>
    @endisset
</x-panel>
