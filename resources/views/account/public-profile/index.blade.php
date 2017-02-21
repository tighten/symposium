@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active"><a href="{{ route('speakers-public.index') }}">Speakers</a></li>
        </ol>

        <h1>Speaker Profiles</h1>

        <p>These are all the speakers who have a public profile on Symposium.</p>

        {{ Form::open(['route' => 'speakers-public.search', 'class' => 'form-inline']) }}
        <div class="form-group">
            {{ Form::label('search_query', 'Search Speakers', ['class' => 'control-label']) }}
            {{ Form::text('search_query', null, ['class' => 'form-control']) }}
            {{ Form::submit('Search', array('class' => 'btn btn-primary')) }}
        </div>
        {{ Form::close() }}
        <br>
        @if (isset($search_query))
            <p>Showing search results for <em>{{ $search_query }}</em>:</p><br>
        @endif

        @forelse ($speakers as $speaker)
            <h3>
                <a href="{{ route('speakers-public.show', ['profile_slug' => $speaker->profile_slug]) }}">
                    {{ $speaker->name }}
                </a>
                @if (isset($search_query) && $speaker->location)
                    <small>{{ $speaker->location }}</small>
                @endif
            </h3>
        @empty
            @if (isset($search_query))
                No speakers match your search criteria.
            @else
                No speakers have made their profiles public yet.
            @endif
        @endforelse
    </div>
@stop

