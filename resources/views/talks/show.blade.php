@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/talks/">Talks</a></li>
            <li><a href="/talks/{{ $talk->id }}">Talk: {{ $current->title }}</a></li>
        </ol>

        @if ($talk->current()->id == $current->id)
        <p class="pull-right">
            <a href="/talks/{{ $talk->id }}/edit" class="btn btn-primary">Edit &nbsp;<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
            <a href="/talks/{{ $talk->id }}/delete" class="btn btn-danger">Delete &nbsp;<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
        </p>
        @endif

        @if ($current === null)
            <p>No revisions yet. @todo Throw exception etc.</p>
        @else

        @if ($talk->current()->id != $current->id)
            REVISION: {{ $current-> created_at }} | <a href="/talks/{{ $talk->id }}">Return to current revision</a>
        @endif

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
                    @foreach ($talk->revisions as $revision)
                        <li {{ $revision->id == $current->id ? 'style="font-weight: bold;"' : '' }}>
                            <a href="/talks/{{ $talk->id }}/revisions/{{ $revision->id }}">{{ $revision->created_at }}</a> {{ $talk->current()->id == $revision->id ? '<i>(current)</i>' : '' }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

    </div>
@stop
