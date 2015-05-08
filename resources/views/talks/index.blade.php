@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active"><a href="/talks/">Talks</a></li>
        </ol>

        <p class="pull-right">
            <a href="/talks/create" class="btn btn-primary">Create Talk &nbsp;<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
        </p>

        <h2>My Talks</h2>

        <p class="list-sort">Sort: <a href="/talks?sort=alpha"{{ $sorting_talk['alpha'] }}>Title</a> | <a
                    href="/talks?sort=date"{{ $sorting_talk['date'] }}>Date</a></p>
        <ul class="list-talks">
            @foreach ($talks as $talk)
                <li><h3><a href="/talks/{{ $talk->id }}">{{ $talk->title }}</a></h3>

                    <p class="talk-meta"><i>{{ $talk->created_at->toFormattedDateString()  }}</i></p>

                    <p><b>Versions</b>
                    @foreach ($talk->versions as $version)
                    | <a href="/talks/{{ $talk->id }}/versions/{{ $version->id }}">{{ $version->nickname }}</a>
                    @endforeach
                    </p>
                    </li>
            @endforeach
        </ul>
    </div>
@stop
