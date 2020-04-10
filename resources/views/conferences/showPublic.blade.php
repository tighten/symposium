@extends('layout')

@section('content')

<div class="body">
    <h1>{{ $conference->title }}</h1>

    @unless (empty($conference->location))
        <p><b>Location:</b>
            {{ $conference->location }}</p>
    @endunless

    <p><b>Date created:</b>
        {{ $conference->created_at->toFormattedDateString() }}</p>

    <p><b>URL:</b>
        <a href="{{ $conference->url }}">{{ $conference->url }}</a></p>

    <p><b>Description:</b><br>
        <!-- TODO: Figure out how we will be handling HTML/etc. -->
        {!! str_replace("\n", "<br>", $conference->description) !!}</p>

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
    </div>
</div>

@endsection
