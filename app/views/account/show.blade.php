@extends('layout')

@section('content')
<div class="container">
	<h2>Account</h2>

	<div class="actions-box">
		<h3>Actions</h3>
		<a href="/account/edit">Edit account</a><br>
		<a href="/account/delete">Delete account</a><br><br>
		<a href="/talks/create">Add new talk</a><br>
	</div>

	<h3>User</h3>
	<b>Email:</b> {{ $user->email }}<br>
	<b>First Name:</b> {{ $user->first_name }}<br>
	<b>Last name:</b> {{ $user->last_name }}<br>

	<h3>Talks</h3>
	<ul>
	@foreach ($user->talks as $talk)
		<li><a href="/talks/{{ $talk->slug }}">{{ $talk->title }}</a></li>
	@endforeach
	</ul>

</div>
@stop
