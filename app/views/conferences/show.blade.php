@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/conferences/">Conferences</a></li>
            <li class="active"><a href="/conferences/{{ $conference->id }}">Conference: {{ $conference->title }}</a></li>
        </ol>

        <h1>{{ $conference->title }}</h1>

        @if ($conference->author_id == Auth::user()->id)
        <p class="pull-right">
            <a href="/conferences/{{ $conference->id }}/edit" class="btn btn-default">Edit</a>
            <a href="/conferences/{{ $conference->id }}/delete" class="btn btn-danger">Delete</a>
        </p>
        @endif

        <p><b>Date created:</b>
            {{ $conference->created_at->toFormattedDateString() }}</p>

        <p><b>URL:</b>
            <a href="{{ $conference->url }}">{{ $conference->url }}</a></p>

        <p><b>Description:</b>
            {{ $conference->description }}</p>

        @if ($conference->joindin_id)
            <p><b>JoindIn ID:</b>
                <a href="http://joind.in/event/view/{{ $conference->joindin_id }}">{{ $conference->joindin_id }}</a></p> </p>
        @endif

        <hr>

        <p><b>Date conference starts:</b>
            {{ $conference->startsAtDisplay() }}</p>

        <p><b>Date conference ends:</b>
            {{ $conference->endsAtDisplay() }}</p>

        <p><b>Date CFP opens:</b>
            {{ $conference->cfpStartsAtDisplay() }}</p>

        <p><b>Date CFP closes:</b>
            {{ $conference->cfpEndsAtDisplay() }}</p>

    </div>
@stop
