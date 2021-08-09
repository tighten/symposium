@extends('app', ['title' => 'Speaker Profiles'])

@section('content')

<x-panel>
    <p class="mb-4">These are all the speakers who have a public profile on Symposium.</p>

    <x-form :action="route('speakers-public.search')">
        <div class="flex">
            <x-input.text
                name="query"
                label="Query"
                placeholder="Search"
                :hideLabel="true"
                :inline="true"
                class="mr-2"
            ></x-input.text>
            <x-button.primary type="submit">Search</x-button.primary>
        </div>
    </x-form>

    <p class="mb-8 text-gray-500">
        @if (isset($query) && $query)
            <small>Showing search results for <em>{{ $query }}</em>:</small>
        @else
            <small>Search by name or location</small>
        @endif
    </p>

    <div class="space-y-4">
        @forelse ($speakers as $speaker)
            <h3 class="text-2xl leading-4 text-indigo-800 hover:underline hover:text-indigo-500">
                <a href="{{ route('speakers-public.show', $speaker->profile_slug) }}">
                    {{ $speaker->name }}
                </a>
            </h3>
            <small class="text-gray-500 @if (!$speaker->location) invisible @endif">{{ $speaker->location ?: '-' }}</small>
        @empty
            @if (isset($query) && $query)
                <p class="text-info">No speakers match your search criteria.</p>
            @else
                <p class="text-info">No speakers have made their profiles public yet.</p>
            @endif
        @endforelse
    </div>
</x-panel>

@endsection
