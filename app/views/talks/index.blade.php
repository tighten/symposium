@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active"><a href="/talks/">Talks</a></li>
        </ol>

        <h2>My Talks</h2>
        <a href="/talks/create" class="create-button">Create Talk</a>

        <p>Sort by: <a href="/talks?sort=alpha"{{ $sorting_talk['alpha'] }}>Title</a> | <a
                    href="/talks?sort=date"{{ $sorting_talk['date'] }}>Date</a></p>
        <ul class="list-talks">
            @foreach ($talks as $talk)
                <li><h3><a href="/talks/{{ $talk->id }}">{{ $talk->title }}</a></h3>

                    <p class="talk-meta"><i>{{ $talk->created_at->toFormattedDateString()  }}</i></p></li>
            @endforeach
        </ul>
    </div>
@stop
