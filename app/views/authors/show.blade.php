@extends('layout')

@section('content')

<div class="container">

	<h1>{{ $author->title }}</h1>

	<h2>User info</h2>
	Name: {{ $author->first_name }} {{ $author->last_name }}<br>
	@if ($author->url != '')
	URL: <a href="{{ $author->url }}">{{ $author->url }}</a><br>
	@endif
	@if ($author->twitter != '')
		Twitter: <a href="http://twitter.com/{{ $author->twitter }}">{{ '@' . $author->twitter }}</a><br>
	@endif

	<h2>Styles</h2>
	<ul>
	@foreach($author->styles as $style)
		<li><a href="/styles/{{ $style->slug }}">{{ $style->title }}</a></li>
	@endforeach
	</ul>
</div>
@stop
