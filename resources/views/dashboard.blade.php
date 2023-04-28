@extends('app')

@section('content')

<h2 class="font-sans text-2xl text-gray-900">Dashboard</h2>

<div class="flex justify-between flex-col md:flex-row gap-6 mt-8">
    <x-panel size="md" :padding="false" title="Conference Submissions" class="flex-1">
        @forelse ($submissions as $submission)
            <div class="border-b flex flex-col sm:flex-row md:flex-col lg:flex-row justify-between p-6 gap-2 sm:gap-10 md:gap-2 lg:gap-10 last:border-b-0">
                <x-heading.list-item
                    :href="route('conferences.show', $submission->conference)"
                    class="flex-1"
                >
                    {{ $submission->conference->title }}
                </x-heading.list-item>
                <div class="flex-shrink lg:text-right">
                    <span class="text-sm text-gray-900">
                        Applied on {{ $submission->created_at->format('F j, Y') }}
                    </span>
                    @if ($submission->acceptance)
                        <x-info icon="check-circle" class="mt-1" icon-color="text-green-500">
                            Accepted
                        </x-info>
                    @endif
                </div>
            </div>
        @empty
            <p class="p-4">No conference submissions</p>
        @endforelse
    </x-panel>

    <x-panel size="md" :padding="false" title="Starred Conferences" class="flex-1">
        @forelse ($conferences as $conference)
            <div class="border-b p-6 last:border-b-0">
                <div class="flex flex-col sm:flex-row md:flex-col lg:flex-row justify-between">
                    <x-heading.list-item
                        :href="route('conferences.show', $conference)"
                        class="flex-1"
                    >
                        {{ $conference->title }}
                    </x-heading.list-item>
                    @if ($conference->appliedTo())
                        <div class="flex-1 sm:text-right md:text-left lg:text-right">
                            <x-tag.success>Submitted</x-tag.success>
                        </div>
                    @endif
                </div>
                <div class="flex flex-col sm:flex-row md:flex-col lg:flex-row justify-between mt-4">
                    <div class="space-y-3">
                        <x-info icon="user-group" icon-color="text-gray-400">
                            {{ $conference->event_dates_display }}
                        </x-info>
                        <x-info icon="map-pin" icon-color="text-gray-400">
                            {{ $conference->location }}
                        </x-info>
                    </div>
                    <div class="space-y-3 mt-3 lg:mt-0">
                        @if ($conference->cfp_starts_at && $conference->cfp_ends_at)
                            <x-info icon="calendar" icon-color="text-gray-400">
                                Opens {{ $conference->cfp_starts_at->toFormattedDateString() }}
                            </x-info>
                            <x-info icon="calendar" icon-color="text-gray-400">
                                Closes {{ $conference->cfp_ends_at->toFormattedDateString() }}
                            </x-info>
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
