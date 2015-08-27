@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active"><a href="{{ route('speakers-public.index') }}">Speakers</a></li>
        </ol>

        <h1>Speaker Profiles</h1>

        <p>These are all the speakers who have a public profile on Symposium.</p>

        @forelse ($speakers as $speaker)
            <h3>
                <a href="{{ route('speakers-public.show', ['profile_slug' => $speaker->profile_slug]) }}">
                    {{ $speaker->first_name }} {{ $speaker->last_name }}
                </a>
            </h3>
        @empty
            No speakers have made their profiles public yet.
        @endforelse
    </div>
@stop

