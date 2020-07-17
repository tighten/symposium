<x-listing :title="$bio->nickname" :href="route('bios.show', $bio)">
    <x-slot name="actions">
        <a href="{{ route('bios.edit', $bio) }}" title="Edit">
            @svg('compose', 'w-5 fill-current inline')
        </a>
        <a href="{{ route('bios.delete', ['id' => $bio->id]) }}" class="ml-3" title="Delete">
            @svg('trash', 'w-5 fill-current inline')
        </a>
    </x-slot>
    <x-slot name="body">{{ $bio->nickname }}</x-slot>
</x-listing>
