<x-panel size="md">
    <div class="bg-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <h3 class="font-sans text-2xl hover:text-indigo-500">
                    <a href="{{ $href }}">
                        {{ $title }}
                    </a>
                </h3>
                @isset($header)
                    {{ $header }}
                @endisset
            </div>
            <div class="text-lg text-indigo-800">
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
