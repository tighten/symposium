@extends('layout')

@section('content')

    <div class="container">
        <a href="/conferences">&lt;&lt; My Conferences</a>

        <h1>{{ $conference->title }}</h1>

        @if ($conference->author_id == Auth::user()->id)
        <p class="pull-right"><a href="/conferences/{{ $conference->id }}/edit">Edit</a> | <a
                    href="/conferences/{{ $conference->id }}/delete">Delete</a>
        </p>
        @endif

        <p><b>Date created:</b>
            {{ $conference->created_at->toFormattedDateString() }}</p>

        <p><b>URL:</b>
            <a href="{{ $conference->url }}">{{ $conference->url }}</a></p>

        <hr>

        <p><b>Date conference starts:</b>
            {{ $conference->starts_at->toFormattedDateString() }}</p>

        <p><b>Date conference ends:</b>
            {{ $conference->ends_at->toFormattedDateString() }}</p>

        <p><b>Date CFP opens:</b>
            {{ $conference->cfp_starts_at->toFormattedDateString() }}</p>

        <p><b>Date CFP closes:</b>
            {{ $conference->cfp_ends_at->toFormattedDateString() }}</p>

    </div>
@stop
