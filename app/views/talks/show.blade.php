@extends('layout')

@section('content')

<div class="container">
	<a href="/talks">&lt;&lt; My Talks</a>

	<h1>{{ $talk->title }}</h1>

	<p><b>Author:</b> 
	<a href="/authors/{{ $author->id }}">{{ $author->first_name }} {{ $author->last_name }}</a></p>

	<p><b>Date uploaded:</b>
	{{ $talk->created_at->toFormattedDateString() }}</p>

	<div class="talk-body">
		{{ $talk->body }}
	</div>

</div>
@stop
