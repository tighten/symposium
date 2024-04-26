@extends('app')

@section('content')

<x-panel>
    <x-button.primary
        :href="route('speakers-public.show', $user->profile_slug)"
        icon="arrow-thick-left"
        class="inline-block"
    >
        Return to profile for {{ $user->name }}
    </x-button.primary>

    <h2 class="text-4xl mt-8">{{ $talk->currentRevision()->title }}</h2>

    <p style="font-style: italic;">
        {{ $talk->currentRevision()->length }} minute {{ $talk->currentRevision()->level }} {{ $talk->currentRevision()->type }}
    </p>

    <h3 class="text-3xl mt-8">Description/Proposal</h3>

    {!! markdown($talk->currentRevision()->getDescription()) !!}
</x-panel>

@endsection
