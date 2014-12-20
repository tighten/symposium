@extends('layout')

@section('content')

<div class="container">

	<h2>All Talks</h2>
	<p>Sort by: <a href="/talks?sort=alpha"{{ $sorting_talk['alpha'] }}>Title</a> | <a href="/talks?sort=date"{{ $sorting_talk['date'] }}>Date</a></p>
	<ul class="list-talks">
		@foreach ($talks as $talk)
		<li><h3><a href="/talks/{{ $talk->slug }}">{{ $talk->title }}</a></h3>
			<p class="talk-meta">By <a href="/authors/{{ $talk->author->id }}">{{ $talk->author->first_name }} {{ $talk->author->last_name }}</a> - <i>{{ $talk->created_at->toFormattedDateString()  }}</i></p></li>
		@endforeach
	</ul>
</div>
@stop
