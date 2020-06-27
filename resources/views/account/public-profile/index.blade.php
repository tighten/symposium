@extends('layout')

@section('content')

<div class="body">
    <div class="col-md-10 col-md-push-1">
        <h1>Speaker Profiles</h1>

        <p>These are all the speakers who have a public profile on Symposium.</p>

        {!! Form::open(['route' => 'speakers-public.search', 'class' => 'form-inline']) !!}
        <div class="form-group">
            {!! Form::text('query', null, ['class' => 'form-control', 'placeholder' => 'Search']) !!}
            {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
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
</div>

@endsection
