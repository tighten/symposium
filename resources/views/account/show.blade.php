@extends('layout')

@section('content')
    <div class="container">
        <h2>Account</h2>

        <div class="actions-box">
            <h3>Actions</h3>
            <a href="/account/edit">Edit account</a><br>
            <a href="/account/delete">Delete account</a><br>
        </div>

        <h3>User</h3>
        <b>Email:</b> {{ $user->email }}<br>
        <b>First Name:</b> {{ $user->first_name }}<br>
        <b>Last name:</b> {{ $user->last_name }}<br><br>

        <h4>Favorited Conferences</h4>
        <ul>
        @foreach ($user->favoritedConferences as $conference)
            <li><a href="/conferences/{{ $conference->id }}">{{  $conference->title }}</a></li>
        @endforeach
        </ul>
    </div>
@stop
