@extends('layout')

@section('content')
    <div class="container">
        <h2>Account</h2>

        <div class="actions-box">
            <h3>Actions</h3>
            <a href="{{ route('account.edit') }}">Edit account</a><br>
            <a href="{{ route('account.delete') }}">Delete account</a><br>
            <a href="{{ route('account.export') }}">Export data</a><br>
        </div>

        <h3>User</h3>
        <p><b>Email:</b><br>{{ $user->email }}</p>
        <p><b>Name:</b><br>{{ $user->name }}</p>
        <p><b>Speaker profile enabled?</b><br>{{ $user->enable_profile ? 'Yes' : 'No' }}</p>
        <p><b>Speaker profile URL slug:</b><br><a href="{{ route('speakers-public.show', [$user->profile_slug]) }}">{{ route('speakers-public.show', [$user->profile_slug]) }}</a></p>
        <br><br>

        <h4>Favorited Conferences</h4>
        <ul>
        @forelse ($user->favoritedConferences as $conference)
            <li><a href="{{ route('conferences.show', ['id' => $conference->id]) }}">{{  $conference->title }}</a></li>
        @empty
            <li>(none)</li>
        @endforelse
        </ul>
    </div>
@stop
