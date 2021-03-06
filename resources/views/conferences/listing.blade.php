<x-listing
    :title="$conference->title"
    :href="route('conferences.show', ['id' => $conference->id])"
>
    <x-slot name="header">
        @if ($conference->cfpIsOpen())
            <span class="bg-indigo-500 font-semibold ml-4 px-1 rounded text-white text-xs">CFP OPEN</span>
        @endif
        @if (auth()->check() && $conference->appliedTo())
            <span class="bg-indigo-500 font-semibold ml-4 px-1 rounded text-white text-xs">Already Sent Proposal</span>
        @endif
    </x-slot>
    <x-slot name="actions">
        @if (auth()->check() && !$conference->isDismissed())
            @if ($conference->isFavorited())
                <a href="/conferences/{{ $conference->id }}/unfavorite">
                    @svg('star-full', 'w-5 fill-current inline')
                </a>
            @else
                <a href="/conferences/{{ $conference->id }}/favorite" class="ml-3">
                    @svg('star-empty', 'w-5 fill-current inline')
                </a>
            @endif
        @endif

        @if (auth()->check() && !$conference->isFavorited())
            @if ($conference->isDismissed())
                <a href="/conferences/{{ $conference->id }}/undismiss" title="I am interested in this conference">
                    @svg('plus', 'w-4 h-4 fill-current stroke-2')
                </a>
            @else
                <a href="/conferences/{{ $conference->id }}/dismiss" title="I am not interested in this conference" class="ml-3">
                    @svg('close', 'w-4 fill-current inline')
                </a>
            @endif
        @endif
    </x-slot>
    <x-slot name="body">
        {{ mb_substr($conference->description, 0, 100) }}...
    </x-slot>
    <x-slot name="footer">
        <div>
            <div class="text-gray-500">Dates</div>
            <div>{{ $conference->startsAtDisplay() }} <span class="text-gray-500">to</span> {{ $conference->endsAtDisplay() }}</div>
        </div>

        @if ($conference->cfp_starts_at && $conference->cfp_ends_at)
            <div>
                <div class="text-gray-500">CFP</div>
                <div>{{ $conference->cfpStartsAtDisplay() }} <span class="text-gray-500">to</span> {{ $conference->cfpEndsAtDisplay() }}</div>
            </div>
        @endif
    </x-slot>
</x-listing>
