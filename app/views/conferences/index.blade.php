@extends('layout')

@section('content')

    <div class="container">

        <h2>All Conferences</h2>
        <a href="/conferences/joindin/import" class="create-button">Import Joind.in conference</a> <a href="/conferences/create" class="create-button">Create Conference</a>

        <p>Sort by: <a href="/conferences?sort=alpha"{{ $sorting_conference['alpha'] }}>Title</a> | <a
                    href="/conferences?sort=date"{{ $sorting_conference['date'] }}>Date</a></p>
        <ul class="list-conferences">
            @foreach ($conferences as $conference)
                <li><h3><a href="/conferences/{{ $conference->id }}">{{ $conference->title }}</a></h3>
                    @if ($conference->cfpIsOpen())
                        <span class="label label-info">CFP OPEN</span>
                    @endif

                    <p class="talk-meta"><i>{{ $conference->starts_at->toFormattedDateString()  }} to {{ $conference->ends_at->toFormattedDateString()  }} | CFP open {{ $conference->cfp_starts_at->toFormattedDateString()  }} to {{ $conference->cfp_ends_at->toFormattedDateString()  }}</i></p></li>
            @endforeach
        </ul>
    </div>
@stop
