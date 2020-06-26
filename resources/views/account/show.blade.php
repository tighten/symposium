@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <h1>Account</h1>

                <div class="actions-box">
                    <h3>Actions</h3>
                    <a href="{{ route('account.edit') }}">Edit account</a><br>
                    <a href="{{ route('account.delete') }}">Delete account</a><br>
                    <a href="{{ route('account.export') }}">Export data</a><br>
                    <a href="{{ route('account.oauth-settings') }}">oAuth settings</a><br>
                </div>

                <h3>User</h3>
                <p><b>Email:</b><br>{{ $user->email }}</p>
                <p><b>Name:</b><br>{{ $user->name }}</p>
                <p><b>Speaker profile enabled?</b><br>{{ $user->enable_profile ? 'Yes' : 'No' }}</p>
                <p><b>Speaker public contact allowed?</b><br>{{ $user->allow_profile_contact ? 'Yes' : 'No' }}</p>
                @if ($user->profile_slug)
                    <p><b>Speaker profile URL slug:</b><br><a href="{{ route('speakers-public.show', $user->profile_slug) }}">{{ route('speakers-public.show', $user->profile_slug) }}</a></p>
                @endif
                @if ($user->location)
                    <p><b>Location:</b><br>{{ $user->location }}</p>
                @endif

                <p><b>Notifications enabled?</b><br>{{ $user->wants_notifications ? 'Yes' : 'No' }}</p>
                <br><br>

                <h4>Dismissed Conferences</h4>
                <ul>
                @forelse ($user->dismissedConferences as $conference)
                    <li><a href="{{ route('conferences.show', ['id' => $conference->id]) }}">{{  $conference->title }}</a></li>
                @empty
                    <li>(none)</li>
                @endforelse
                </ul>
            </div>
        </div>
    </div>
@stop
