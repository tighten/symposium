@extends('layout', ['title' => 'Speaker Profiles'])

@section('content')

<x-panel class="mt-4">
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

    <p class="text-gray-500 mb-8">
        @if (isset($query) && $query)
            <small>Showing search results for <em>{{ $query }}</em>:</small>
        @else
            <small>Search by name or location</small>
        @endif
    </p>

    @forelse ($speakers as $speaker)
        <h3 class="mb-0 mt-5 text-2xl leading-4 text-indigo">
            <a href="{{ route('speakers-public.show', $speaker->profile_slug) }}">
                {{ $speaker->name }}
            </a>
        </h3>
        <small class="text-gray-500">{{ $speaker->location }}</small>
    @empty
        @if (isset($query) && $query)
            <p class="text-info">No speakers match your search criteria.</p>
        @else
            <p class="text-info">No speakers have made their profiles public yet.</p>
        @endif
    @endforelse
</x-panel>

@endsection
