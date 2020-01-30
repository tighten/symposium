<div class="border-2 border-indigo-200 rounded mt-4 hover:border-indigo">
    <div class="bg-white p-4">
            <div class="flex items-center justify-between">
                    <h3 class="m-0 font-sans text-2xl">
                            <a href="{{ route('talks.show', ['id' => $talk->id]) }}">
                                    {{ $talk->current()->title }}
                            </a>
                    </h3>
                    <div class="text-indigo-500 text-lg">
                            <a href="{{ route('talks.edit', ['id' => $talk->id]) }}" title="Edit">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                            </a>
                            <a href="{{ route('talks.delete', ['id' => $talk->id]) }}" class="ml-3" title="Delete">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
                            @if ($talk->isArchived())
                                    <a href="{{ route('talks.restore', ['id' => $talk->id]) }}" class="ml-3" title="Restore">
                                            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                                    </a>
                            @else
                                    <a href="{{ route('talks.archive', ['id' => $talk->id]) }}" class="ml-3" title="Archive">
                                            <span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span>
                                    </a>
                            @endif
                    </div>
            </div>
    </div>
    <div class="bg-indigo-150 p-4 font-sans">
            <div class="text-gray-500">Created</div>
            <div class="flex justify-between">
                    <div>{{ $talk->created_at->toFormattedDateString() }}</div>
                    <div>{{ $talk->current()->length }}-minute {{ $talk->current()->level }} {{ $talk->current()->type }}</div>
            </div>
    </div>
</div>
