@extends('layout')

@section('content')

<div class="container">
	<h1>Edit Style</h1>

	<ul class="errors">
	@foreach($errors->all() as $message)
		<li>{{ $message }}</li>
	@endforeach
	</ul>

	{{ Form::open(array('action' => array('StylesController@update', $style->slug), 'class' => 'edit-style-form')) }}

	{{ Form::label('title', 'Title') }}<br>
	{{ Form::text('title', $style->title) }}<br><br>

	{{ Form::label('description', 'Description') }}<br>
	{{ Form::textarea('description', $style->description) }}<br><br>

	{{ Form::label('source', 'Style Source') }}<br>
	{{ Form::textarea('source', $style->source) }}<br><br>

	{{ Form::label('format', 'Style Type') }}<br>
	{{ Form::radio('format', 'css', $style->format == 'css') }} CSS
	{{ Form::radio('format', 'scss', $style->format == 'scss', array('disabled' => true)) }} SCSS
	{{ Form::radio('format', 'sass', $style->format == 'sass', array('disabled' => true)) }} Sass<br><br>

	{{ Form::submit('Update') }}<br><br>

	{{ Form::close() }}

</div>
@stop
