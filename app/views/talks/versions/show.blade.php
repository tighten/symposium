@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/talks/">Talks</a></li>
            <li><a href="/talks/{{ $version->talk->id }}">Talk: {{ $version->talk->title }}</a></li>
            <li class="active"><a href="/talks/{{ $version->talk->id }}/versions/{{ $version->id }}">Version: {{ $version->nickname }}</a></li>
        </ol>

        <p><strong>{{ $version->talk->title }} - {{ $version->nickname }}</strong></p>

        <p class="pull-right">
            <a href="/talks/{{ $version->talk->id }}/versions/{{ $version->id }}/edit">Edit</a> |
            <a href="/talks/{{ $version->talk->id }}/versions/{{ $version->id }}/delete">Delete</a>
        </p>

        @if ($current === null)
            {{--This is a weird situation. How do we have a version with no revisions?--}}
            <p>No revisions yet. @todo handle how to create the details when first making a version</p>
        @else

            <h1>{{ $current->title }}</h1>

            <p style="font-style: italic;">
                {{ $current->length }} minute {{ $current->level }} {{ $current->type }}
            </p>

            <h2>Description/Proposal</h2>
            {{ $current->description ?: '<i>(empty)</i>' }}

            <h2>Outline</h2>
            {{ $current->outline ?: '<i>(empty)</i>' }}

            <h2>Organizer Notes</h2>
            {{ $current->organizer_notes?: '<i>(empty)</i>' }}

            <hr>

            <h2>Revisions</h2>
            <ul>
                @foreach ($version->revisions as $index => $revision)
                    <li
                    @if ($index === 0)
                        style="font-weight: bold;"
                        @endif}}><a href="/talks/{{ $version->talk->id }}/versions/{{ $version->id }}/{{ $revision->id }}">{{ $revision->created_at }}</a></li>
                @endforeach
            </ul>

        @endif

    </div>
@stop
