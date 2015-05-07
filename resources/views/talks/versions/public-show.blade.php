@extends('layout')

@section('content')

    <div class="container">
        @if ($current === null)
            <p>No revisions yet. @todo Throw exception etc.</p>
        @else
        <h1>{{ $current->title }}</h1>

        <div class="row" style="clear: both;">
            <div class="col-lg-6">
                <p><b>{{ $author->first_name }} {{ $author->last_name }}</b></p>

                <p style="font-style: italic;">
                    {{ $current->length }} minute {{ $current->level }} {{ $current->type }}
                </p>

                <h3>Description/Proposal</h3>
                {{ $current->getHtmledDescription() }}

                <h3>Outline</h3>
                {{ $current->getHtmledOutline() }}

                <h3>Organizer Notes</h3>
                {{ $current->getHtmledOrganizerNotes() }}

            </div>
        </div>
        @endif

    </div>
@stop
