@extends('layout')

@section('content')

<div class="col-md-10 col-md-push-1">
    <h1>Speaker Profiles</h1>

    <p>These are all the speakers who have a public profile on Symposium.</p>

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
    @if (isset($query) && $query)
        <p class="text-muted"><small>Showing search results for <em>{{ $query }}</em>:</small></p>
    @else
        <p class="text-muted"><small>Search by name or location</small></p>
    @endif

    @forelse ($speakers as $speaker)
        <h3 class="mb-0">
            <a href="{{ route('speakers-public.show', $speaker->profile_slug) }}">
                {{ $speaker->name }}
            </a>
        </h3>
        <small class="text-muted">{{ $speaker->location }}</small>
    @empty
        @if (isset($query) && $query)
            <p class="text-info">No speakers match your search criteria.</p>
        @else
            <p class="text-info">No speakers have made their profiles public yet.</p>
        @endif
    @endforelse
</div>

@endsection
