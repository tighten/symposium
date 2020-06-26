@extends('layout')

@section('content')
    <div class="container body">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <p>
                    <a href="{{ route('speakers-public.show', $user->profile_slug) }}" class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;
                        Return to profile for {{ $user->name }}
                    </a>
                </p><br>

                <h1 class="page-title">{{ $bio->nickname }}</h1>

                {!! str_replace("\n", "<br>", $bio->body) !!}
            </div>
        </div>
    </div>
@stop
