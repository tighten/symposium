@extends('layout')

@section('content')

<div class="bg-white py-10 px-56 mt-8">
    <p>
        <a href="{{ route('speakers-public.show', ['profileSlug' => $user->profile_slug]) }}" class="bg-indigo-500 text-white rounded px-4 py-2 text-center">
            @svg('arrow-thick-left', 'w-4 mr-1 fill-current inline') Return to profile for {{ $user->name }}
        </a>
    </p><br>

    <h2 class="text-4xl">{{ $bio->nickname }}</h2>

    {!! str_replace("\n", "<br>", $bio->body) !!}
</div>

@endsection
