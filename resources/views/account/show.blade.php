@extends('layout')

@section('content')
    <div class="container">
        <h2>Account</h2>

        <div class="actions-box">
            <h3>Actions</h3>
            <a href="/account/edit">Edit account</a><br>
            <a href="/account/delete">Delete account</a><br>
            <a href="/account/export">Export data</a><br>
        </div>

        <h3>User</h3>
        <p><b>Email:</b><br>{{ $user->email }}</p>
        <p><b>First Name:</b><br>{{ $user->first_name }}</p>
        <p><b>Last name:</b><br>{{ $user->last_name }}</p>

        <br><br>

        <h4>Favorited Conferences</h4>
        <ul>
        @foreach ($user->favoritedConferences as $conference)
            <li><a href="/conferences/{{ $conference->id }}">{{  $conference->title }}</a></li>
        @endforeach
        </ul>
    </div>
@stop
