@extends('layouts.index', ['title' => 'Dashboard'])

@section('sidebar')
    <x-panel size="sm" class="w-full">
        <div class="flex justify-center h-16">
            <div class="w-24 h-24 p-1 mt-4 bg-white border-2 border-indigo-800 rounded-full">
                <div class="w-full h-full rounded-full">
                    <img
                        src="{{ auth()->user()->profile_picture_hires }}"
                        class="rounded-full"
                        alt="profile picture"
                    >
                </div>
            </div>
        </div>
        <div class="p-4 pt-12 text-center bg-indigo-100">
            <h2 class="text-xl">{{ auth()->user()->name }}</h2>
        </div>
    </x-panel>
@endsection

@section('list')
    <x-panel size="md" title="Stared Conferences">
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
            <p class="pb-4">No favorited conferences</p>
        @endforelse
    </x-panel>
@endsection
