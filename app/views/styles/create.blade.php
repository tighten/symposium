@extends('layout')

@section('content')

<div class="container">
	<h1>Create Style</h1>

	{{ Form::open(array('action' => 'StylesController@store')) }}

	{{ Form::label('title', 'Title') }}<br>
	{{ Form::text('title') }}<br><br>

	{{ Form::label('slug', 'Slug') }}<br>
	{{ Form::text('slug') }}<br><br>

	{{ Form::label('description', 'Description') }}<br>
	{{ Form::textarea('description') }}<br><br>

	{{ Form::label('source', 'Style Source') }}<br>
	{{ Form::textarea('source') }}<br><br>

	{{ Form::label('format', 'Style Type') }}<br>
	{{ Form::radio('format', 'css', true) }} CSS
	{{ Form::radio('format', 'scss') }} SCSS
	{{ Form::radio('format', 'sass') }} Sass<br><br>

	{{ Form::submit('Create') }}<br><br>

	{{ Form::close() }}

</div>
@stop
