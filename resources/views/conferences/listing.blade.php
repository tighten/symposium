<div class="border-b p-6 last:border-b-0">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <x-heading.list-item
                :href="route('conferences.show', $conference)"
            >
                {{ $conference->title }}
            </x-heading.list-item>
            @if ($conference->isFlagged())
                <span class="text-danger" title="An issue has been reported for this conference.">
                    @svg('flag', 'cursor-pointer inline ml-4 w-5 fill-current')
                </span>
            @endif
            @if ($conference->cfpIsOpen())
                <x-tag>CFP OPEN</x-tag>
            @endif
            @if (! $conference->has_cfp)
                <x-tag>No CFP</x-tag>
            @endif
            @if (auth()->check() && $conference->appliedTo())
                <x-tag>Already Sent Proposal</x-tag>
            @endif
        </div>
        <div class="text-indigo-600">
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
        </div>
    </div>
    <div class="mt-4 space-y-3">
        <x-info icon="calendar" icon-color="text-gray-400">
            <span class="text-gray-400">Dates:</span>
            {{ $conference->starts_at->format('D M j, Y') ?? '[Date not set]' }}
            <span class="text-gray-400">to</span>
            {{ $conference->ends_at->format('D M j, Y') ?? '[Date not set]' }}
        </x-info>
        <x-info icon="calendar" icon-color="text-gray-400">
            <span class="text-gray-400">CFP:</span>
            {{ $conference->cfp_starts_at?->format('D M j, Y') ?? '[Date not set]' }}
            <span class="text-gray-400">to</span>
            {{ $conference->cfp_ends_at?->format('D M j, Y') ?? '[Date not set]' }}
        </x-info>
    </div>
</div>
