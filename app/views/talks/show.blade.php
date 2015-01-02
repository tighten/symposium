@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/talks/">Talks</a></li>
            <li class="active"><a href="/talks/{{ $talk->id }}">Talk: {{ $talk->title }}</a></li>
        </ol>

        <h1>{{ $talk->title }}</h1>

        <p class="pull-right">
            <a href="/talks/{{ $talk->id }}/createVersion">Create new version</a> |
            <a href="/talks/{{ $talk->id }}/delete">Delete</a>
        </p>

        <p><b>Created:</b>
            {{ $talk->created_at->toFormattedDateString() }}</p>

        <h2>Versions</h2>
        <ul>
        @foreach ($talk->versions as $version)
            <li>
                <a href="/talks/{{ $talk->id }}/versions/{{ $version->id }}/delete"><button type="button" class="btn btn-xs btn-danger">Delete</button></a>
                <a href="/talks/{{ $talk->id }}/versions/{{ $version->id }}/edit"><button type="button" class="btn btn-xs btn-default">Edit</button></a> -
                <a href="/talks/{{ $talk->id }}/versions/{{ $version->id }}">{{ $version->nickname }}</a>
                @if ($version->current())
                    <i>{{ $version->current()->length }}-minute {{ $version->current()->type }}</i>
                @endif
                </li>
        @endforeach
        </ul>

    </div>
@stop
