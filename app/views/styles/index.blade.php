@extends('layout')

@section('content')

<div class="container">

	<ul>
		@foreach($styles as $style)
		<li><a href="/styles/{{ $style->slug }}">{{ $style->title }}</a></li>
		@endforeach
	</ul>
</div>
@stop
