@extends('layout')

@section('content')

<div class="container">

	<h1>{{ $author->title }}</h1>

	User info

	<br><br>

	Styles<br>
	<ul>
	@foreach($author->styles as $style)
		<li><a href="/styles/{{ $style->id }}">{{ $style->title }}</a></li>
	@endforeach
	</ul>
</div>
@stop
