@extends('layout')

@section('content')

<div class="container">

	<h2>All Styles</h2>
	<p><a href="/styles?sort=date">Sort by Date</a> | <a href="/styles?sort=alpha">Sort Alphabetically</a></p>
	<ul class="list-styles">
		@foreach($styles as $style)
		<li><h3><a href="/styles/{{ $style->slug }}">{{ $style->title }}</a></h3>
			<p class="style-meta">By <a href="/authors/{{ $style->author->id }}">{{ $style->author->first_name }} {{ $style->author->last_name }}</a> - <i>{{ $style->created_at->toFormattedDateString()  }}</i></p></li>
		@endforeach
	</ul>
</div>
@stop
