@extends('layout')

@section('content')

    <div class="container body">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <p>
                    <a href="{{ route('speakers-public.show', ['profileSlug' => $user->profile_slug]) }}" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;
                        Return to profile for {{ $user->name }}
                    </a>
                </p><br>

                <h1 class="page-title">{{ $talk->current()->title }}</h1>

                <p style="font-style: italic;">
                    {{ $talk->current()->length }} minute {{ $talk->current()->level }} {{ $talk->current()->type }}
                </p>

                <h3>Description/Proposal</h3>

{{--                @markdown($talk->current()->getDescription())--}}
            </div>
        </div>
    </div>
@stop
