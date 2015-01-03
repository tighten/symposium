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
            <a href="/talks/{{ $version->talk->id }}/versions/{{ $version->id }}/edit" class="btn btn-default">Edit</a>
            <a href="/talks/{{ $version->talk->id }}/versions/{{ $version->id }}/delete" class="btn btn-danger">Delete</a>
        </p>

        @if ($current === null)
            {{-- Shouldn't happen. --}}
            <p>No revisions yet. @todo Throw exception etc.</p>
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
