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

        <div class="row">
            <div class="col-md-6">
                <p><b>Date conference starts:</b>
                    {{ $conference->startsAtDisplay() }}</p>

                <p><b>Date conference ends:</b>
                    {{ $conference->endsAtDisplay() }}</p>

                <p><b>Date CFP opens:</b>
                    {{ $conference->cfpStartsAtDisplay() }}</p>

                <p><b>Date CFP closes:</b>
                    {{ $conference->cfpEndsAtDisplay() }}</p>
            </div>
            <div class="col-md-6">
                <h3>My Talks</h3>
                <strong>Applied to speak at this conference</strong>
                <ul>
                    @if ($talksAtConference->isEmpty())
                        <li>None</li>
                    @endif
                    @foreach ($talksAtConference as $talk)
                        <li><a href="#" class="btn btn-xs btn-default">Un-Submit</a> <a href="{{ $talk->getUrl() }}">{{ $talk->title }}</a> |  Change status [accepted, rejected, submitted]</li>
                    @endforeach
                </ul>

                <strong>Others</strong>
                <ul>
                    @if ($talksNotAtConference->isEmpty())
                        <li>None</li>
                    @endif
                    @foreach ($talksNotAtConference as $talk)
                        <li><a href="#" class="btn btn-xs btn-primary">Submit</a> {{ $talk->title }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop
