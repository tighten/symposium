@extends('layout')

@section('content')

    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="{{ route('speakers-public.index') }}">Speakers</a></li>
            <li class="active"><a href="{{ route('speakers-public.show', ['profile_slug' => $user->profile_slug]) }}">{{ $user->first_name }} {{ $user->last_name }}</a></li>
        </ol>

        <div class="pull-right">
           <img src="{{ Gravatar::src($user->email, 200) }}" class="public-speaker-picture">
        </div>

        <h1>{{ $user->first_name }} {{ $user->last_name }}</h1>

        <p>@todo: We need to allow them to mark any talk as public or not. Probably to define a profile picture other than their gravatar. And add a big block of wysiwyg text at the top, too. And a link to their joind.in profile.
        Also probably social profiles and everything. Maybe sort their talks too. Also, each *submission* needs to be allowed to set a unique Joind.in URL. And make them contact-able.</p>

        <p>What's the primary goal we're targeting here? For a speaker to be able to make it known which talks they're interested in giving again, and to prove to conference organizers that they're a good speaker and this particular talk has merit. Also, it's for conference organizers to be able to easily find talks interesting to them.</p>

        @forelse ($talks as $talk)
            <h3><a href="{{ route('speakers-public.talks.show', ['profile_slug' => $user->profile_slug, 'talk_id' => $talk->id]) }}">{{ $talk->current()->title }}</a></h3>
            <p class="talk-meta">{{ $talk->current()->length }}-minute {{ $talk->current()->type }} talk at {{ $talk->current()->level }} level</p>
        @empty
            This speaker has not made any of their talks public yet.
        @endforelse
    </div>
@stop

