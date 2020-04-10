<div class="border-2 border-indigo-200 rounded mt-4 hover:border-indigo">
    <div class="bg-white p-4">
        <div class="flex items-center justify-between">
            <h3 class="m-0 font-sans text-2xl">
                <a href="{{ route('bios.show', ['id' => $bio->id]) }}">
                    {{ $bio->nickname }}
                </a>
            </h3>
            <div class="text-indigo-500 text-lg">
                <a href="{{ route('bios.edit', ['id' => $bio->id]) }}" title="Edit">
                    @svg('compose', 'w-5 fill-current inline')
                </a>
                <a href="{{ route('bios.delete', ['id' => $bio->id]) }}" class="ml-3" title="Delete">
                    @svg('trash', 'w-5 fill-current inline')
                </a>
                <button type="button" data-clipboard data-clipboard-text="{{ $bio->body }}" title="Copy" class="ml-3">
                    @svg('clipboard', 'w-5 fill-current inline')
                </button>
            </div>
        </div>
        <div class="mt-3 font-sans text-gray-500">
            {{ $bio->nickname }}
        </div>
    </div>
</div>
