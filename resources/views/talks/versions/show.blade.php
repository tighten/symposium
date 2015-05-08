@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/talks/">Talks</a></li>
            <li><a href="/talks/{{ $version->talk->id }}">Talk: {{ $version->talk->title }}</a></li>
            <li class="active"><a href="/talks/{{ $version->talk->id }}/versions/{{ $version->id }}">Version: {{ $version->nickname }}</a></li>
        </ol>

        <p class="pull-right">
        <!--
            <a href="/s/{{ $version->publicId }}" class="btn btn-default">Share &nbsp;<span class="glyphicon glyphicon-share" aria-hidden="true"></span></a>
            -->
            <a href="/talks/{{ $version->talk->id }}/versions/{{ $version->id }}/edit" class="btn btn-primary">Edit &nbsp;<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
            <a href="/talks/{{ $version->talk->id }}/versions/{{ $version->id }}/delete" class="btn btn-danger">Delete &nbsp;<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
        </p>

        @if ($current === null)
            <p>No revisions yet. @todo Throw exception etc.</p>
        @else
        <h1>{{ $current->title }}</h1>

        <div class="row" style="clear: both;">
            <div class="col-lg-5 pull-right">
                <h3>Meta Data</h3>
                <p><strong>Talk nickname:</strong> {{ $version->talk->title }}<br>
                    <strong>Version nickname:</strong> {{ $version->nickname }}</p>
            </div>
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
                    @foreach ($version->revisions as $index => $revision)
                        <li
                        @if ($index === 0)
                            style="font-weight: bold;"
                            @endif}}><a href="/talks/{{ $version->talk->id }}/versions/{{ $version->id }}/{{ $revision->id }}">{{ $revision->created_at }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

    </div>
@stop
