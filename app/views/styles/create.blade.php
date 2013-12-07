@extends('layout')

@section('content')

<div class="container">
	<h1>Create Style</h1>

	{{ Form::open(array('action' => 'StylesController@store', 'class' => 'new-style-form')) }}

	{{ Form::label('title', 'Title') }}<br>
	{{ Form::text('title') }}<br><br>

	{{ Form::label('description', 'Description') }}<br>
	{{ Form::textarea('description') }}<br><br>

	{{ Form::label('source', 'Style Source') }}<br>
	{{ Form::textarea('source') }}<br><br>

	{{ Form::label('format', 'Style Type') }}<br>
	{{ Form::radio('format', 'css', true) }} CSS
	{{ Form::radio('format', 'scss', false, array('disabled' => true)) }} SCSS
	{{ Form::radio('format', 'sass', false, array('disabled' => true)) }} Sass<br><br>

	{{ Form::submit('Create') }}<br><br>

	{{ Form::close() }}

</div>
@stop
