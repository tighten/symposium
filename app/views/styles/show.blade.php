@extends('layout')

@section('content')

<div class="container">
	<a href="/styles">&lt;&lt; All styles</a>

	<h1>{{ $style->title }}</h1>

	<p><b>Author:</b> 
	<a href="/authors/{{ $author->id }}">{{ $author->first_name }} {{ $author->last_name }}</a></p>

	<p><b>Date uploaded:</b>
	{{ $style->created_at->toFormattedDateString() }}</p>

	<ul class="tab-nav">
		<li class="active"><a href="#" data-tab-toggle="#tab-preview">Preview</a></li>
		<li><a href="#" data-tab-toggle="#tab-source">Source</a></li>
	</ul>
	<div id="tab-preview" class="tab tab-preview active">
		<iframe src="/styles/preview/{{ $style->id }}">

		</iframe>
	</div>
	<div id="tab-source" class="tab tab-source">
		<textarea class="css-source">{{ $style->source }}</textarea>
	</div>

</div>
@stop
