<div class="border-b p-6 last:border-b-0">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <x-heading.list-item
                :href="route('conferences.show', $conference)"
            >
                {{ $conference->title }}
            </x-heading.list-item>
            @if ($conference->isFlagged())
                <span
                    class="text-danger"
                    title="An issue has been reported for this conference."
                >
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
            @if (auth()->check() && !$conference->isDismissedBy(auth()->user()))
                <x-button.icon
                    :icon="$conference->isFavoritedBy(auth()->user())
                        ? 'star-full'
                        : 'star-empty'
                    "
                    class="ml-3"
                    wire:click="toggleFavorite('{{ $conference->id }}')"
                />
            @endif

            @if (auth()->check() && !$conference->isFavoritedBy(auth()->user()))
                <x-button.icon
                    :icon="$conference->isDismissedBy(auth()->user())
                        ? 'plus'
                        : 'close'
                    "
                    class="ml-3"
                    :title="$conference->isDismissedBy(auth()->user())
                        ? 'I am interested in this conference'
                        : 'I am not interested in this conference'
                    "
                    wire:click="toggleDismissed('{{ $conference->id }}')"
                />
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
