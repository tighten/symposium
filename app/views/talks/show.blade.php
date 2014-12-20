@extends('layout')

@section('content')

<div class="container">
	<a href="/talks">&lt;&lt; My Talks</a>

	<h1>{{ $talk->title }}</h1>

	<p class="pull-right"><a href="/talks/{{ $talk->id }}/edit">Edit</a> | <a href="/talks/{{ $talk->id }}/delete">Delete</a></p>

	<p><b>Date uploaded:</b>
	{{ $talk->created_at->toFormattedDateString() }}</p>

	<div class="talk-body">
		{{ $talk->body }}
	</div>

</div>
@stop
