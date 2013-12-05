@extends('layout')

@section('content')

<div class="container">

	<h2>All Styles</h2>
	<p><a href="/styles?sort=date">Sort by Date</a> | <a href="/styles?sort=alpha">Sort Alphabetically</a></p>
	<ul>
		@foreach($styles as $style)
		<li><a href="/styles/{{ $style->slug }}" style="font-weight: bold;">{{ $style->title }}</a><br><i style="font-size: 80%;">{{ $style->created_at->toFormattedDateString()  }}</i></li>
		@endforeach
	</ul>
</div>
@stop
