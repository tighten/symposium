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
            <a href="/talks/{{ $talk->id }}/createVersion" class="btn btn-primary">Create new version</a>
            <a href="/talks/{{ $talk->id }}/edit" class="btn btn-default">Edit talk nickname</a>
            <a href="/talks/{{ $talk->id }}/delete" class="btn btn-danger">Delete</a>
        </p>

        <p><b>Created:</b>
            {{ $talk->created_at->toFormattedDateString() }}</p>

        <h2>Versions</h2>
        <ul>
            @if (count($talk->versions) == 0)
                <li>No versions yet. <a href="/talks/{{ $talk->id }}/createVersion" class="btn btn-primary btn-sm">Add one</a><br>
                    <i>Each talk can have one or more "versions"--think about, for example, the difference between a "lightning" talk or a "keynote." Or maybe the difference between the talk as you'd propose it to one group of people vs. another.</i></li>
            @else
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
            @endif
        </ul>

    </div>
@stop
