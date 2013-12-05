@extends('layout')

@section('content')
<div class="container">
	<form class="login-form" method="post" action="/log-in">
		<h2>Log in</h2>
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
		<br>
		<button class="button button--primary" type="submit">Sign in</button>
	</form>
</div>
@stop
