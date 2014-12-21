@extends('layout')

@section('content')

    <div class="container">

        <h2>All Conferences</h2>
        <a href="/conferences/create" class="pull-right">Create Conference</a>

        <p>Sort by: <a href="/conferences?sort=alpha"{{ $sorting_conference['alpha'] }}>Title</a> | <a
                    href="/conferences?sort=date"{{ $sorting_conference['date'] }}>Date</a></p>
        <ul class="list-conferences">
            @foreach ($conferences as $conference)
                <li><h3><a href="/conferences/{{ $conference->id }}">{{ $conference->title }}</a></h3>

                    <p class="talk-meta"><i>{{ $conference->created_at->toFormattedDateString()  }}</i></p></li>
            @endforeach
        </ul>
    </div>
@stop
