@extends('layout')

@section('content')

<div class="container">

	<h2>All Talks</h2>
	<!--p>Sort by: <a href="/styles?sort=alpha"{{ $sorting_style['alpha'] }}>Title</a> | <a href="/styles?sort=date"{{ $sorting_style['date'] }}>Date</a> | <a href="/styles?sort=popularity"{{ $sorting_style['popularity'] }}>Popularity</a></p-->
	<ul class="list-talks">
		@foreach ($talks as $talk)
		<li><h3><a href="/styles/{{ $talk->slug }}">{{ $talk->title }}</a></h3>
			<p class="style-meta">By <a href="/authors/{{ $talk->author->id }}">{{ $talk->author->first_name }} {{ $talk->author->last_name }}</a> - <i>{{ $talk->created_at->toFormattedDateString()  }}</i> - popularity {{ round($talk->visits / $total_visits * 100) }}</p></li>
		@endforeach
	</ul>
</div>
@stop
