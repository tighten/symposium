@extends('layout')

@section('content')

<div class="container">
	<a href="/talks">&lt;&lt; All Talks</a>

	<h1>{{ $talk->title }}</h1>

	<p><b>Author:</b> 
	<a href="/authors/{{ $author->id }}">{{ $author->first_name }} {{ $author->last_name }}</a></p>

	<p><b>Date uploaded:</b>
	{{ $talk->created_at->toFormattedDateString() }}</p>

	<ul class="tab-nav">
		<li class="active"><a href="#" data-tab-toggle="#tab-preview">Preview</a></li>
		<li><a href="#" data-tab-toggle="#tab-source">Source</a></li>
		@if (Auth::user() && $talk->author->id == Auth::user()->id)
		<li><a href="/talks/{{ $talk->slug }}/edit/">Edit</a></li>
		@endif
	</ul>
	<div id="tab-preview" class="tab tab-preview active">
		<iframe src="/talks/{{ $talk->slug }}/preview/">

		</iframe>
	</div>
	<div id="tab-source" class="tab tab-source">
		<textarea class="css-source">{{ $talk->source }}</textarea>
	</div>

</div>
@stop
