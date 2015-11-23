@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Home</a></li>
            <li><a href="{{ route('speakers-public.index') }}">Speakers</a></li>
            <li><a href="{{ route('speakers-public.show', ['profile_slug' => $user->profile_slug]) }}">{{ $user->name }}</a></li>
            <li class="active"><a href="{{ route('speakers-public.talks.show', ['id' => $talk->id]) }}">Talk: {{ $talk->current()->title }}</a></li>
        </ol>

        <div class="pull-right">
            <a href="{{ route('speakers-public.show', ['profile_slug' => $user->profile_slug]) }}" class="btn btn-default">
                Return to profile for {{ $user->name }}
                &nbsp;<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
            </a>
        </div>

        <h1>{{ $talk->current()->title }}</h1>

        <div class="row">
            <div class="col-lg-6">
                <p style="font-style: italic;">
                    {{ $talk->current()->length }} minute {{ $talk->current()->level }} {{ $talk->current()->type }}
                </p>

                <h3>Description/Proposal</h3>
                {{ $talk->current()->getHtmledDescription() }}

                <p>@todo: Do we show organizer notes?</p>
                <h3>Organizer Notes</h3>
                {{ $talk->current()->getHtmledOrganizerNotes() }}
            </div>
        </div>
    </div>
@stop
