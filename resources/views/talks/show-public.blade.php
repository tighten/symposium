@extends('layout')

@section('content')

<div class="bg-white py-10 px-10 lg:px-56 mt-8">
    <a
        href="{{ route('speakers-public.show', $user->profile_slug) }}"
        class="bg-indigo-500 text-white rounded px-4 py-2 text-center"
    >
        @svg('arrow-thick-left', 'w-4 mr-1 fill-current inline') Return to profile for {{ $user->name }}
    </a>

    <h2 class="text-4xl mt-8">{{ $talk->current()->title }}</h2>

    <p style="font-style: italic;">
        {{ $talk->current()->length }} minute {{ $talk->current()->level }} {{ $talk->current()->type }}
    </p>

    <h3 class="text-3xl mt-8">Description/Proposal</h3>

    {!! markdown($talk->current()->getDescription()) !!}
</div>

@endsection
