@extends('layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <div class="pull-right">
                    <a href="{{ route('speakers-public.show', ['profileSlug' => $user->profile_slug]) }}" class="btn btn-default">
                        Return to profile for {{ $user->name }}
                        &nbsp;<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
                    </a>
                </div>

                <h1>{{ $talk->current()->title }}</h1>

                <div class="row">
                    <div class="col-lg-6">
                        <p style="font-style: italic;">
                            {{ $talk->current()->length }} minute {{ $talk->current()->level }} {{ $talk->current()->type }}
                        </p>

                        <h3>Description/Proposal</h3>
                        {{ $talk->current()->getHtmledDescription() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
