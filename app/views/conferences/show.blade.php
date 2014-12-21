@extends('layout')

@section('content')

    <div class="container">
        <a href="/conferences">&lt;&lt; My Conferences</a>

        <h1>{{ $conference->title }}</h1>

        <p class="pull-right"><a href="/conferences/{{ $conference->id }}/edit">Edit</a> | <a
                    href="/conferences/{{ $conference->id }}/delete">Delete</a>
        </p>

        <p><b>Date created:</b>
            {{ $conference->created_at->toFormattedDateString() }}</p>

        <p><b>URL:</b>
            {{ $conference->url }}</p>

    </div>
@stop
