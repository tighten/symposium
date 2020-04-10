@extends('layout')

@section('content')

<div class="body">
    <div class="row">
        <div class="col-md-8 col-md-push-2">
            <p>
                <a href="{{ route('speakers-public.show', ['profileSlug' => $user->profile_slug]) }}" class="btn btn-default">
                    @svg('arrow-thick-left', 'w-4 mr-1 fill-current inline') Return to profile for {{ $user->name }}
                </a>
            </p><br>

            <h1 class="page-title">{{ $bio->nickname }}</h1>

            {!! str_replace("\n", "<br>", $bio->body) !!}
        </div>
    </div>
</div>

@endsection
