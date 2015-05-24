@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/talks/">Talks</a></li>
            <li><a href="/talks/{{ $talk->id }}">Talk: {{ $talk->title }}</a></li>
        </ol>

        <p class="pull-right">
            <a href="/talks/{{ $talk->id }}/edit" class="btn btn-primary">Edit &nbsp;<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
            <a href="/talks/{{ $talk->id }}/delete" class="btn btn-danger">Delete &nbsp;<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
        </p>

        @if ($current === null)
            <p>No revisions yet. @todo Throw exception etc.</p>
        @else
        <h1>{{ $current->title }}</h1>

        <div class="row" style="clear: both;">
            <div class="col-lg-6">
                <p style="font-style: italic;">
                    {{ $current->length }} minute {{ $current->level }} {{ $current->type }}
                </p>

                <h3>Description/Proposal</h3>
                {{ $current->getHtmledDescription() }}

                <h3>Outline</h3>
                {{ $current->getHtmledOutline() }}

                <h3>Organizer Notes</h3>
                {{ $current->getHtmledOrganizerNotes() }}

                <hr>

                <h3>Revisions</h3>
                <ul>
                    @foreach ($talk->revisions as $index => $revision)
                        <li
                        @if ($index === 0)
                            style="font-weight: bold;"
                            @endif}}><a href="/talks/{{ $talk->id }}/{{ $revision->id }}">{{ $revision->created_at }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

    </div>
@stop
