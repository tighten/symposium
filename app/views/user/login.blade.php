@extends('layout')

@section('content')
<div class="container">
	<form class="form-signin form-horizontal" method="post" action="/login">
		<h2>Please sign in</h2>
		<div class="control-group">
			<label class="control-label" for="email">Email:</label>
			<div class="controls">
				<input type="text" id="email" name="email" placeholder="Email address" value="">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="password">Password:</label>
			<div class="controls">
				<input type="password" id="password" name="password" placeholder="Password" value="">
			</div>
		</div>
		<button class="btn btn-large btn-primary" type="submit">Sign in</button>
	</form>
</div>
@stop
