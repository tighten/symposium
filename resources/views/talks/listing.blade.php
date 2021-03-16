<x-listing :title="$talk->current()->title" :href="route('talks.show', $talk)">
    <x-slot name="actions">
        <a href="{{ route('talks.edit', $talk) }}" title="Edit">
            @svg('compose', 'w-5 fill-current inline')
        </a>
        <a href="{{ route('talks.delete', ['id' => $talk->id]) }}" class="ml-3" title="Delete">
            @svg('trash', 'w-5 fill-current inline')
        </a>
        @if ($talk->isArchived())
            <a href="{{ route('talks.restore', ['id' => $talk->id]) }}" class="ml-3" title="Restore">
                @svg('folder-outline', 'w-5 fill-current inline')
            </a>
        @else
            <a href="{{ route('talks.archive', ['id' => $talk->id]) }}" class="ml-3" title="Archive">
                @svg('folder', 'w-5 fill-current inline')
            </a>
        @endif
    </x-slot>
    <x-slot name="footer">
        <div>
            <div class="text-gray-500">Created</div>
            <div>{{ $talk->created_at->toFormattedDateString() }}</div>
        </div>
        <div class="flex items-end">
            <div>{{ $talk->current()->length }}-minute {{ $talk->current()->level }} {{ $talk->current()->type }}</div>
        </div>
    </x-slot>
</x-listing>
