@extends('app')

@section('content')

<h2 class="font-sans text-2xl text-gray-900">Dashboard</h2>

<div class="flex justify-between gap-6 mt-8">
    <x-panel size="md" title="Conference Submissions" class="flex-1">
        @forelse ($submissions as $submission)
            <div class="border-b flex justify-between p-6 gap-10 last:border-b-0">
                <h3 class="flex-1 font-semibold text-indigo-600">
                    <a href="{{ route('conferences.show', $submission->conference) }}">
                        {{ $submission->conference->title }}
                    </a>
                </h3>
                <div class="flex-shrink text-right">
                    <span class="text-sm text-gray-900">
                        Applied on {{ $submission->created_at->format('F j, Y') }}
                    </span>
                    @if ($submission->acceptance)
                        <span class="flex items-center mt-1 text-green-500">
                            @svg('check-circle', 'inline w-4 mr-1 fill-current')
                            <span class="text-sm text-gray-500">Accepted</span>
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <p class="p-4">No conference submissions</p>
        @endforelse
    </x-panel>

    <x-panel size="md" title="Stared Conferences" class="flex-1">
        @forelse ($conferences as $conference)
            <div class="border-b p-6 last:border-b-0">
                <div class="flex justify-between">
                    <h3 class="flex-1 font-semibold text-indigo-600">
                        <a href="{{ route('conferences.show', $conference) }}">
                            {{ $conference->title }}
                        </a>
                    </h3>
                    @if ($conference->appliedTo())
                        <div class="flex-1 text-right">
                            <x-tag.success>Subitted</x-tag.success>
                        </div>
                    @endif
                </div>
                <div class="flex justify-between mt-4">
                    <div class="space-y-3">
                        <span class="text-gray-500 text-sm flex">
                            @svg('user-group', 'inline w-4 mr-1')
                            {{ $conference->event_dates_display }}
                        </span>
                        <span class="text-gray-500 text-sm flex">
                            @svg('map-pin', 'inline w-4 mr-1')
                            {{ $conference->location }}
                        </span>
                    </div>
                    <div class="space-y-3">
                        @if ($conference->cfp_starts_at && $conference->cfp_ends_at)
                            <span class="text-gray-500 text-sm flex">
                                @svg('calendar', 'inline w-4 mr-1')
                                Opens {{ $conference->cfp_starts_at->toFormattedDateString() }}
                            </span>
                            <span class="text-gray-500 text-sm flex">
                                @svg('calendar', 'inline w-4 mr-1')
                                Closes {{ $conference->cfp_ends_at->toFormattedDateString() }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <p class="p-4">No starred conferences</p>
        @endforelse
    </x-panel>
</div>

@endsection
