@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-10 col-md-push-1">
                <div class="pull-right">
                   <img src="{{ Gravatar::src($user->email, 200) }}" class="public-speaker-picture"><br>
                   <a href="{{ route('speakers-public.email', ['profileSlug' => $user->profile_slug]) }}">Contact {{ $user->name }}</a>
                </div>

                <h1>{{ $user->name }}</h1>
                <p>{{ $user->name }} is using Symposium to manage their talks and bios.</p>
                <?php /*
                    What's the primary goal we're targeting here?
                    For a speaker to be able to make it known which talks they're
                    interested in giving again, and to prove to conference organizers
                    that they're a good speaker and this particular talk has merit.
                    Also, it's for conference organizers to be able to easily find
                    talks interesting to them.
                */ ?>

                <h2>Talks</h2>
                @forelse ($talks as $talk)
                    <h3><a href="{{ route('speakers-public.talks.show', ['profile_slug' => $user->profile_slug, 'talk_id' => $talk->id]) }}">{{ $talk->current()->title }}</a></h3>
                    <p class="talk-meta">{{ $talk->current()->length }}-minute {{ $talk->current()->type }} talk at {{ $talk->current()->level }} level</p>
                @empty
                    This speaker has not made any of their talks public yet.
                @endforelse

                <h2>Bios</h2>
                @forelse ($bios as $bio)
                    <h3><a href="{{ route('speakers-public.bios.show', ['profile_slug' => $user->profile_slug, 'bio_id' => $bio->id]) }}">{{ $bio->nickname }}</a></h3>
                @empty
                    This speaker has not made any of their bios public yet.
                @endforelse
            </div>
        </div>
    </div>
@stop

