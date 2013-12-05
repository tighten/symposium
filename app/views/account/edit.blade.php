@extends('layout')

@section('content')
<div class="container">
	<h2>Edit Account</h2>

	<ul class="errors">
 	@foreach($errors->all() as $message)
 		<li>{{ $message }}</li>
	@endforeach
	</ul>

	<h3>User</h3>
	{{ Form::model($user, array('url' => array('account/edit'))) }}

	{{ Form::label('first_name', 'First Name') }}<br>
	{{ Form::text('first_name') }}<br><br>

	{{ Form::label('last_name', 'Last Name') }}<br>
	{{ Form::text('last_name') }}<br><br>
	
	{{ Form::label('email', 'Email Address') }}<br>
	{{ Form::email('email') }}<br><br>

	{{ Form::label('twitter', 'Twitter Handle') }}<br>
	{{ '@' . Form::text('twitter') }}<br><br>

	{{ Form::label('url', 'URL') }}<br>
	{{ Form::text('url') }}<br><br>

	{{ Form::submit('Save') }}

	{{ Form::close() }}

</div>
@stop
